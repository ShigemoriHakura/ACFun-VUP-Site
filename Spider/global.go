package main

import (
    "database/sql"
)

var Version = "0.0.1"
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