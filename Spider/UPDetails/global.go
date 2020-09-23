package main

import (
	"database/sql"
	"net/http"
	"time"
)

var Version = "0.0.4"
var Database_Host string
var Database_Port string
var Database_DB string
var Database_Name string
var Database_Pass string
var Database_TLS bool
var RefreshRate = 300
var SpiderWait = 300
var ACFun_Name string
var ACFun_Pass string

var ACCookies []string

var Database_Mysql *sql.DB
var CronCounter = 0
var UperMapCache = make(map[int]map[string]string)

var client = &http.Client{Timeout: 2 * time.Second}

//ACFun API数据
var ACFunLiveAPI = "https://live.acfun.cn/rest/pc-direct/user/userInfo?userId="
var ACFunUserAPI = "https://www.acfun.cn/u/"
var ACFunUserMedalAPI = "https://api-new.app.acfun.cn/rest/app/fansClub/live/medalInfo?uperId="
var ACFunLiveInfoAPI = "https://api-new.app.acfun.cn/rest/app/live/info?authorId="