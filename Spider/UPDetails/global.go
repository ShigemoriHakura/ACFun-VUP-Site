package main

import (
    "database/sql"
)

var Version = "0.0.3"
var Database_Host string
var Database_Port string
var Database_DB   string
var Database_Name string
var Database_Pass string
var Database_TLS  bool
var RefreshRate   = 300
var SpiderWait    = 300

var Database_Mysql *sql.DB
var CronCounter = 0
var UperMapCache = make(map[int]map[string]string)

//ACFun API数据
var ACFunLiveAPI = "https://live.acfun.cn/rest/pc-direct/user/userInfo?userId="
var ACFunUserAPI = "https://www.acfun.cn/u/"