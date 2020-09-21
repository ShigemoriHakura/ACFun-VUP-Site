package main

import (
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
	"time"

	"github.com/orzogc/acfundanmu"
	jsoniter "github.com/json-iterator/go"
)

func main() {
	log.Println("[Main]", "启动中，版本：", Version)
	importConfig()
	log.Println("[Main]", "配置文件载入完成，链接数据库中")

	databaseLink := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8&tls=%v", Database_Name, Database_Pass, Database_Host, Database_Port, Database_DB, Database_TLS)
	initMysql(databaseLink)
	log.Println("[Main]", "数据库载入完成，爬虫进程启动")
	loginToACFun()
	runMainProcess()
}

func loginToACFun() {
	if ACFun_Name != "" && ACFun_Pass != "" {
		log.Println("[Main]", "尝试登录ACFun账号中")
		cookies, err := acfundanmu.Login(ACFun_Name, ACFun_Pass)
		if err != nil {
			log.Println("[Main]", ACFun_Name, "登录出错：", err)
		} else {
			log.Println("[Main]", ACFun_Name, "登录成功")
			ACCookies = cookies
		}
	}
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
		jsonData := getACUserInfo(v["uperid"])
		if jsonData != nil {
			//log.Println("[Main]", "用户raw数据：", string(jsonData))
			any := jsoniter.Get(jsonData)
			acUser := make(map[string]string)
			getSuccess := false
			var followers string
			if !strings.Contains(any.Get("profile", "followed").ToString(), "万") {
				followers = any.Get("profile", "followed").ToString()
				getSuccess = true
			} else {
				followLiveInfo, err := getACUserLiveInfoFollowers(v["uperid"])
				if err != nil {
					log.Println("[Main]", "过完粉丝用户数据获取失败：", err)
					getSuccess = false
				} else {
					anyLiveInfo := jsoniter.Get(followLiveInfo)
					followers = anyLiveInfo.Get("user", "fanCountValue").ToString()
					getSuccess = true
				}
			}
			if getSuccess {
				uperid, _ := strconv.ParseInt(v["uperid"], 10, 64)
				_, medalName, err := acfundanmu.GetMedalInfo(uperid, ACCookies)
				if err != nil {
					log.Println("[Main]", "粉丝牌数据获取失败：", err)
				}
				//log.Println(medalName)
				acUser["followers"] = followers
				acUser["medalName"] = medalName
				acUser["uperid"] = v["uperid"]
				acUser["rawdata"] = string(jsonData)
				acUser["spaceImage"] = any.Get("profile", "spaceImage").ToString()
				acUser["registerTime"] = any.Get("profile", "registerTime").ToString()
				acUser["following"] = any.Get("profile", "following").ToString()
				acUser["name"] = any.Get("profile", "name").ToString()
				acUser["signature"] = any.Get("profile", "signature").ToString()
				acUser["verifiedText"] = any.Get("profile", "verifiedText").ToString()
				acUser["isContractUp"] = any.Get("profile", "isContractUp").ToString()
				acUser["contentCount"] = any.Get("profile", "contentCount").ToString()
				acUser["lastLoginTime"] = any.Get("profile", "lastLoginTime").ToString()
				acUser["headUrl"] = any.Get("profile", "headUrl").ToString()
				updateMap[v["id"]] = acUser
				if(medalName != ""){
					log.Printf("[Avatar] %v (%v) 关注: %v, 关注者: %v, 用户名: %v, 粉丝牌：%v", v["name"], v["uperid"], acUser["following"], followers, acUser["name"], medalName)
				}else{
					log.Printf("[Avatar] %v (%v) 关注: %v, 关注者: %v, 用户名: %v", v["name"], v["uperid"], acUser["following"], followers, acUser["name"])
				}
			} else {
				log.Println("[Main]", "用户数据正则失败")
			}
		} else {
			log.Println("[Main]", "用户数据获取失败")
		}
		timeSleep(SpiderWait / 1000)

	}
	makeMysqlUpdateQueue(updateMap)
}

func makeMysqlUpdateQueue(updateMap map[string]map[string]string) {
	var dataString = "INSERT INTO vup_up_data VALUES"
	if len(updateMap) > 0 {
		var uperids = ""
		var updatedTime = ""
		var registerTime = ""
		var nowName = ""

		var medalName = ""
		for k, v := range updateMap {
			dataString += fmt.Sprintf("(%v, %v, '%v', %v, %v, '%v', '%v', '%v', %v, '%v'),", v["uperid"], time.Now().Unix(), v["spaceImage"], v["followers"], v["following"], v["name"], v["signature"], v["verifiedText"], v["contentCount"], v["headUrl"])
			uperids = uperids + k + ","
			updatedTime += "WHEN " + k + " THEN " + strconv.Itoa(int(time.Now().Unix())) + "\n"
			registerTime += "WHEN " + k + " THEN " + v["registerTime"] + "\n"
			nowName += "WHEN " + k + " THEN '" + v["name"] + "'\n"
			if(v["medalName"] != ""){
				medalName += fmt.Sprintf("(%v,'%v', %v),", v["uperid"],  v["medalName"], time.Now().Unix())
			}
		}
		dataString = strings.TrimRight(dataString, ",")
		uperids = strings.TrimRight(uperids, ",")
		medalName = strings.TrimRight(medalName, ",")
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

		var dataUpdated = "UPDATE vup_up_list SET last_date = CASE id\n" + updatedTime + "END,\n registerTime = CASE id\n" + registerTime + "END,\n nowName = CASE id\n" + nowName + "END\n WHERE id IN(" + uperids + ")"
		//log.Println(dataUpdated)
		rows, err = Database_Mysql.Exec(dataUpdated)
		if err != nil {
			log.Println("[MysqlUpdatedTime]", "更新失败：", err)
			return
		}
		rowCount, err = rows.RowsAffected()
		if err != nil {
			log.Println("[MysqlUpdatedTime]", "更新失败：", err)
		}
		log.Println("[MysqlUpdatedTime]", "更新成功，影响行数：", int(rowCount))
		
		var medalUpdated = "INSERT INTO vup_up_medal (uperid, clubName, up_date) VALUES " + medalName + " ON DUPLICATE KEY UPDATE clubName=VALUES(clubName), up_date=VALUES(up_date);"
		//log.Println(medalUpdated)
		rows, err = Database_Mysql.Exec(medalUpdated)
		if err != nil {
			log.Println("[MysqlUpdatedMedal]", "更新失败：", err)
			return
		}
		rowCount, err = rows.RowsAffected()
		if err != nil {
			log.Println("[MysqlUpdatedMedal]", "更新失败：", err)
		}
		log.Println("[MysqlUpdatedMedal]", "更新成功，影响行数：", int(rowCount))
	}
}
