package main

import (
	"fmt"
	"log"
	"os"
	"strings"
	"time"

	jsoniter "github.com/json-iterator/go"
)

func main() {
	log.Println("[Main]", "启动中，版本：", Version)
	importConfig()
	log.Println("[Main]", "配置文件载入完成，链接数据库中")

	databaseLink := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8&tls=%v", Database_Name, Database_Pass, Database_Host, Database_Port, Database_DB, Database_TLS)
	initMysql(databaseLink)
	log.Println("[Main]", "数据库载入完成，爬虫进程启动")
	runMainProcess()
}

func runMainProcess() {
	err := Database_Mysql.Ping()
	if err != nil {
		log.Println("[Main]", "发生数据库连接错误：", err)
		os.Exit(3)
	}
	ch := make(chan string, 1)
	log.Println("[Main]", "爬虫刷新间隔：", RefreshRate)
	for {
		log.Println("[Main]", "爬虫开始爬取，累计次数：", CronCounter)
		go func() {
			checkUpers(CronCounter)
			ch <- "done"
		}()
		select {
		case <-ch:
			log.Println("[Main]", "爬虫爬取完成，累计次数：", CronCounter)
		case <-time.After(time.Duration(RefreshRate-1) * time.Second):
			log.Println("[Main]", "爬虫爬取超时", CronCounter)
		}
		CronCounter++
		timeSleep(RefreshRate)
	}
}

func checkUpers(counter int) {
	upersMap, err := selectUpersInDB()
	if err != nil {
		log.Println("[Main]", "跳过本次爬取")
		return
	}
	UperMapCache = upersMap
	var updateMap = make(map[string]map[string]string)
	for _, v := range upersMap {
		log.Println("[Main]", "处理用户：", v["name"])
		jsonData := getACUserLiveInfo(v["uperid"])
		if jsonData != nil {
			//log.Println("[Main]", "用户raw数据：", string(jsonData))
			any := jsoniter.Get(jsonData)
			acUser := make(map[string]string)
			acUser["uperid"] = v["uperid"]
			acUser["rawdata"] = string(jsonData)
			if any.Get("liveId").ToString() != "" {
				acUser["isLive"] = "1"
				acUser["liveId"] = any.Get("liveId").ToString()
				acUser["onlineCount"] = any.Get("onlineCount").ToString()
				acUser["likeCount"] = any.Get("likeCount").ToString()
				acUser["title"] = any.Get("title").ToString()
				acUser["createTime"] = any.Get("createTime").ToString()
				acUser["coverUrl"] = any.Get("coverUrls", 0).ToString()
				updateMap[v["id"]] = acUser
				//log.Println(acUser["createTime"])
				log.Printf("[Main] %v (%v) 直播ID: %v, 标题: %v, 在线观众: %v, 爱心数量: %v, 封面: %v", v["name"], v["uperid"], acUser["liveId"], acUser["title"], acUser["onlineCount"], acUser["likeCount"], acUser["coverUrl"])
			} else {
				acUser["isLive"] = "0"
				acUser["liveId"] = ""
				acUser["onlineCount"] = "0"
				acUser["likeCount"] = "0"
				acUser["title"] = ""
				acUser["createTime"] = "0"
				acUser["coverUrl"] = ""
				updateMap[v["id"]] = acUser
				log.Printf("[Main] %v (%v) 未在直播中", v["name"], v["uperid"])
			}
		} else {
			log.Println("[Main]", "用户数据获取失败")
		}
		timeSleep(SpiderWait / 1000)

	}
	makeMysqlUpdateQueue(updateMap)
}

func makeMysqlUpdateQueue(updateMap map[string]map[string]string) {
	var dataString = "INSERT INTO vup_up_live_data VALUES"
	if len(updateMap) > 0 {
		for _, v := range updateMap {
			dataString += fmt.Sprintf("(%v, %v, %v, %v, %v, '%v', %v, '%v'),", v["uperid"], time.Now().Unix(), v["isLive"], v["onlineCount"], v["likeCount"], v["title"], v["createTime"], v["coverUrl"])
		}
		dataString = strings.TrimRight(dataString, ",")
		//log.Println(dataString)
		rows, err := Database_Mysql.Exec(dataString)
		if err != nil {
			log.Println("[MysqlUpdate]", "更新失败：", err)
			return
		}
		rowCount, err := rows.RowsAffected()
		if err != nil {
			log.Println("[MysqlUpdate]", "更新失败：", err)
		}
		log.Println("[MysqlUpdate]", "更新成功，影响行数：", int(rowCount))
	}
}
