package main

import (
	"os"
	"log"
	"time"
	"net/http"
	"io/ioutil"
	"github.com/akkuman/parseConfig"
)

func getACUserLiveInfo(id string) []byte {
	client := &http.Client{Timeout: 2 * time.Second}
	var url = ACFunLiveInfoAPI + id
	req, err := http.NewRequest("GET", url, nil)

	if err != nil {
		log.Println(err)
		return nil
	}

	req.Header.Set("User-Agent", "Chrome/83.0.4103.61")

	resp, err := client.Do(req)
	if err != nil {
		log.Println(err)
		return nil
	}
	defer resp.Body.Close()

	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return nil
	}

	return body
}

func timeSleep(second int){
    time.Sleep(time.Duration(second) * time.Second)
}

func importConfig() {
	defer func() {
		if r := recover(); r != nil {
			log.Println("[Main]", "发生配置文件错误：", r)
			os.Exit(3)
		}
	}()

	var config = parseConfig.New("config.json")
	Database_Host = config.Get("Database_Host").(string)
	Database_Port = config.Get("Database_Port").(string)
	Database_DB   = config.Get("Database_DB").(string)
	Database_Name = config.Get("Database_Name").(string)
	Database_Pass = config.Get("Database_Pass").(string)
	Database_TLS  = config.Get("Database_TLS").(bool)
	RefreshRate = int(config.Get("RefreshRate").(float64))
	SpiderWait  = int(config.Get("SpiderWait").(float64))
}