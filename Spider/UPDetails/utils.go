package main

import (
	"io/ioutil"
	"log"
	"net/http"
	"os"
	"regexp"
	"strings"
	"time"

	"github.com/akkuman/parseConfig"
)

func getACUserInfo(id string) []byte {
	var url = ACFunLiveAPI + id
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

func getACUserFollowers(id string) (string, error) {
	var url = ACFunUserAPI + id
	req, err := http.NewRequest("GET", url, nil)

	if err != nil {
		return "0", err
	}

	req.Header.Set("User-Agent", "Chrome/83.0.4103.61")

	resp, err := client.Do(req)
	if err != nil {
		return "0", err
	}
	defer resp.Body.Close()
	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		return "0", err
	}

	var cleanBody = strings.Replace(string(body), " ", "", -1)
	cleanBody = strings.Replace(cleanBody, "\n", "", -1)
	var hrefRegexp = regexp.MustCompile(`id="followed-pagination"data-total="[^\"]+"`)
	match := hrefRegexp.FindStringSubmatch(cleanBody)
	if match != nil {
		var matches = match[0]
		matches = strings.Replace(matches, `id="followed-pagination"data-total="`, "", -1)
		matches = strings.Replace(matches, "\"", "", -1)
		log.Printf("[UserMatch]用户(%v) match: %v", id, matches)
		return matches, nil
	}
	return "0", nil
}

func timeSleep(second int) {
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
	Database_DB = config.Get("Database_DB").(string)
	Database_Name = config.Get("Database_Name").(string)
	Database_Pass = config.Get("Database_Pass").(string)
	Database_TLS = config.Get("Database_TLS").(bool)
	RefreshRate = int(config.Get("RefreshRate").(float64))
	SpiderWait = int(config.Get("SpiderWait").(float64))
}
