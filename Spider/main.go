package main

import (
	"os"
	"fmt"
	"log"
	"time"
	"strconv"
	"strings"

	jsoniter "github.com/json-iterator/go"
)

func main(){
	log.Println("[Main]", "启动中，版本：", Version)
	importConfig()
	log.Println("[Main]", "配置文件载入完成，链接数据库中")

	databaseLink := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8&tls=%v", Database_Name, Database_Pass, Database_Host, Database_Port, Database_DB, Database_TLS)
	initMysql(databaseLink)
	log.Println("[Main]", "数据库载入完成，爬虫进程启动")
	runMainProcess()
}

func runMainProcess(){
	err := Database_Mysql.Ping()
    if err != nil {
        log.Println("[Main]", "发生数据库连接错误：", err)
        os.Exit(3)
	}
    ch := make(chan string, 1)
	log.Println("[Main]", "爬虫刷新间隔：", RefreshRate)
    for {
        timeSleep(RefreshRate)
		log.Println("[Main]", "爬虫开始爬取，累计次数：", CronCounter)
        go func() {
            checkUpers(CronCounter)
            ch <- "done"
        }()
        select {
        case <-ch:
			log.Println("[Main]", "爬虫爬取完成，累计次数：", CronCounter)
        case <-time.After(time.Duration(RefreshRate - 1) * time.Second):
			log.Println("[Main]", "爬虫爬取超时", CronCounter)
        }
        CronCounter += 1
    }
}

func checkUpers(counter int){
	upersMap, err := selectUpersInDB()
	if(err != nil){
		log.Println("[Main]", "跳过本次爬取")
		return
	}
	var updateMap = make(map[string]map[string]string)
	for _, v := range upersMap{
		log.Println("[Main]", "处理用户：", v["name"])
		jsonData := getACUserInfo(v["uperid"])
		if(jsonData != nil){
			//log.Println("[Main]", "用户raw数据：", string(jsonData))
			any := jsoniter.Get(jsonData)
			acUser := make(map[string]string)
			getSuccess := false
			var followers string
			if(!strings.Contains(any.Get("profile", "followed").ToString(), "万")){
				followers = any.Get("profile", "followed").ToString()
				getSuccess = true
			}else{
				follower, err := getACUserFollowers(v["uperid"])
				if(err != nil){
					log.Println("[Main]", "用户数据正则获取失败：" , err)
					getSuccess = false
				}else{
					followers = follower
					getSuccess = true
				}
			}
			if(getSuccess){
				acUser["followers"] = followers
				acUser["uperid"] = v["uperid"]
				acUser["rawdata"] = string(jsonData)
				acUser["registerTime"] = any.Get("profile", "registerTime").ToString()
				acUser["following"] = any.Get("profile", "following").ToString()
				acUser["name"] = any.Get("profile", "name").ToString()
				acUser["signature"] = any.Get("profile", "signature").ToString()
				acUser["contentCount"] = any.Get("profile", "contentCount").ToString()
				acUser["headUrl"] = any.Get("profile", "headUrl").ToString()
				updateMap[v["id"]] = acUser
				log.Printf("[Avatar] %v (%v) 关注: %v, 关注者: %v, 用户名: %v", v["name"], v["uperid"], acUser["following"], followers, acUser["name"])
			}else{
				log.Println("[Main]", "用户数据正则失败")
			}
		}else{
			log.Println("[Main]", "用户数据获取失败")
		}
		timeSleep(SpiderWait / 1000)
		
	}
	makeMysqlUpdateQueue(updateMap)
}

func makeMysqlUpdateQueue(updateMap map[string]map[string]string){
	var dataString = "INSERT INTO vup_up_data VALUES"
	if(len(updateMap) > 0){
        var uperids = ""
		var updatedTime  = ""
		var registerTime = ""
		var nowName      = ""
		for k, v := range updateMap{
			dataString += fmt.Sprintf("(%v, %v, '%v', %v, %v, '%v', '%v', %v, '%v'),", v["uperid"], time.Now().Unix(), v["rawdata"], v["followers"], v["following"], v["name"], v["signature"], v["contentCount"], v["headUrl"])
			uperids = uperids + k + ","
			updatedTime  += "WHEN " + k + " THEN " + strconv.Itoa(int(time.Now().Unix())) + "\n"
			registerTime += "WHEN " + k + " THEN " + v["registerTime"] + "\n"
			nowName      += "WHEN " + k + " THEN '" + v["name"] + "'\n"
		}
		dataString = strings.TrimRight(dataString, ",")
		uperids    = strings.TrimRight(uperids, ",")
		//log.Println(dataString)
		rows, err := Database_Mysql.Exec(dataString)
        if err != nil {
			log.Println("[MysqlUpdate]", "更新失败：", err)
			return
        }
		rowCount, err := rows.RowsAffected()
		if err != nil{
			log.Println("[MysqlUpdate]", "更新失败：", err)
		}
		log.Println("[MysqlUpdate]", "更新成功，影响行数：", int(rowCount))

		var dataUpdated = "UPDATE vup_up_list SET last_date = CASE id\n" + updatedTime + "END,\n registerTime = CASE id\n" + registerTime + "END,\n nowName = CASE id\n" + nowName + "END\n WHERE id IN(" + uperids + ")"
		//log.Println(dataUpdated)
		rows, err = Database_Mysql.Exec(dataUpdated)
        if err != nil {
			log.Println("[MysqlUpdatedTime]", "更新失败：", err)
			return
        }
		rowCount, err = rows.RowsAffected()
		if err != nil{
			log.Println("[MysqlUpdatedTime]", "更新失败：", err)
		}
		log.Println("[MysqlUpdatedTime]", "更新成功，影响行数：", int(rowCount))
	}
}