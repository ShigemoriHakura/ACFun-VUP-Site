package main

import (
	"log"
	"strconv"
    "database/sql"
	_ "github.com/go-sql-driver/mysql"
)

func initMysql(link string) {
    Database_Mysql, _ = sql.Open("mysql", link)
    Database_Mysql.SetMaxOpenConns(100)
    Database_Mysql.SetMaxIdleConns(10)
}

func selectUpersInDB() (map[int]map[string]string, error){
	var uperMap = make(map[int]map[string]string)
    rows, err := Database_Mysql.Query("SELECT id, uperid, name FROM vup_up_list WHERE enabled = 1")
    if err != nil {
        log.Println("[Mysql]", "发生错误：", err)
		return uperMap, nil
    }
	for rows.Next() {
		var id int
		var uperid int
		var name string
		err = rows.Scan(&id, &uperid, &name)
		checkErr(err)
		uper := make(map[string]string)
		uper["id"] = strconv.Itoa(id)
		uper["uperid"] = strconv.Itoa(uperid)
		uper["name"] = name
		uperMap[id] = uper
	}
	rows.Close()
	return uperMap, nil
}

func checkErr(err error) {  
    if err != nil {  
        log.Println("[Error]", "发生错误：", err)
    }  
}