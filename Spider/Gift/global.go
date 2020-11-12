package main

import (
	"sync"
	"database/sql"
)

const defaultAvatar = "https://tx-free-imgs.acfun.cn/style/image/defaultAvatar.jpg"

var BackendVersion = "0.0.1"

var Database_Host string
var Database_Port string
var Database_DB string
var Database_Name string
var Database_Pass string
var Database_TLS bool
var RefreshRate = 10

var ACRoomMap struct {
	sync.Mutex
	roomMap map[int]struct{}
}

var ACCookies []string

var MessageQ MessageQueue
var RoomQ MessageQueue

var Database_Mysql *sql.DB
var CronCounter = 0
var UperMapCache = make(map[int]map[string]string)