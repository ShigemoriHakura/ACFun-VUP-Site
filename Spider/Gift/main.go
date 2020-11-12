package main

import (
	"fmt"
	"bufio"
	"context"
	"log"
	"os"
	"strconv"
	"time"

	"github.com/akkuman/parseConfig"
	jsoniter "github.com/json-iterator/go"
	"github.com/orzogc/acfundanmu"
)

func main() {
	defer func() {
		log.Println("[Main]", "请按回车关闭。。。")
		for {
			consoleReader := bufio.NewReaderSize(os.Stdin, 1)
			_, _ = consoleReader.ReadByte()
			os.Exit(0)
		}
	}()

	ACRoomMap.roomMap = make(map[int]struct{})

	log.Println("[Main]", "读取配置文件中")
	importConfig()
	log.Println("[Main]", "启动中，AcLiveChat，", BackendVersion)
	startMessageQueue()
	startRoomQueue()
	go processMessageQueue()
	go processRoomQueue()

	databaseLink := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?charset=utf8mb4&tls=%v", Database_Name, Database_Pass, Database_Host, Database_Port, Database_DB, Database_TLS)
	initMysql(databaseLink)
	log.Println("[Main]", "数据库载入完成，进程启动")
	runMainProcess()
}

func runMainProcess() {
	err := Database_Mysql.Ping()
	if err != nil {
		log.Println("[Main]", "发生数据库连接错误：", err)
		os.Exit(3)
	}
	ch := make(chan string, 1)
	log.Println("[Main]", "检查间隔：", RefreshRate)
	for {
		log.Println("[Main]", "开始检查，累计次数：", CronCounter)
		go func() {
			checkUpers(CronCounter)
			ch <- "done"
		}()
		select {
		case <-ch:
			log.Println("[Main]", "检查完成，累计次数：", CronCounter)
		case <-time.After(time.Duration(RefreshRate-1) * time.Second):
			log.Println("[Main]", "检查超时", CronCounter)
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
	processRoomRetryQueue(upersMap)
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
}

func startMessageQueue() {
	MessageQ := initMessageQueue()
	log.Println("[Message Queue]", "初始化成功，当前队列长度：", MessageQ.Size())
}

func startRoomQueue() {
	RoomQ := initRoomQueue()
	log.Println("[Room Queue]", "初始化成功，当前队列长度：", RoomQ.Size())
}

func processMessageQueue() {
	for {
		for !MessageQ.IsEmpty() {
			tmp := MessageQ.Dequeue()
			log.Println("[Message Queue]", tmp.RoomID, "处理消息")
			json := jsoniter.ConfigCompatibleWithStandardLibrary
			ddata, err := json.Marshal(tmp.Data)
			if err == nil {
				//log.Println("Sent: ", 1, string(ddata))
				//connHub.broadcast <- ddata
				go sendMysqlData(ddata, tmp.RoomID)
				time.Sleep(time.Duration(80) * time.Millisecond)
			}
			/*ACConnMap.Lock()
			connHub, ok := ACConnMap.hubMap[tmp.RoomID]
			ACConnMap.Unlock()
			if ok {
				json := jsoniter.ConfigCompatibleWithStandardLibrary
				ddata, err := json.Marshal(tmp.Data)
				if err == nil {
					//log.Println("Sent: ", 1, string(ddata))
					connHub.broadcast <- ddata
					time.Sleep(time.Duration(80) * time.Millisecond)
				}
			}*/
		}
		time.Sleep(1 * time.Second)
	}
}

func processRoomQueue() {
	for {
		for !RoomQ.IsEmpty() {
			tmp := RoomQ.Dequeue()
			log.Println("[Room Queue]", tmp.RoomID, "处理房间")
			ACRoomMap.Lock()
			_, ok := ACRoomMap.roomMap[tmp.RoomID]
			ACRoomMap.Unlock()
			if !ok {
				log.Println("[Room Queue]", tmp.RoomID, "建立WS链接")
				go startACWS(tmp.RoomID)
			} else {
				log.Println("[Room Queue]", tmp.RoomID, "已存在，不新建")
			}
		}
		time.Sleep(1 * time.Second)
	}
}

func processRoomRetryQueue(upersMap map[int]map[string]string) {
	for _, v := range upersMap {
		log.Println("[Main]", "处理用户：", v["name"], v["uperid"])
		uperid, _ := strconv.Atoi(v["uperid"])
		ACRoomMap.Lock()
		if _, ok := ACRoomMap.roomMap[uperid]; !ok {
			log.Println("[Room Retry Queue]", uperid, "建立WS链接")
			ACRoomMap.roomMap[uperid] = struct{}{}
			go startACWS(uperid)
		}
		ACRoomMap.Unlock()
		log.Println("[Room Retry Queue]", "检查完成")
		time.Sleep(50 * time.Millisecond)
	}
}

func startACWS(roomID int) {
	ACRoomMap.Lock()
	ACRoomMap.roomMap[roomID] = struct{}{}
	ACRoomMap.Unlock()
	ctx, cancel := context.WithCancel(context.Background())
	defer func() {
		log.Println("[Danmaku]", roomID, "结束")
		ACRoomMap.Lock()
		delete(ACRoomMap.roomMap, roomID)
		ACRoomMap.Unlock()
		cancel()
	}()
	log.Println("[Danmaku]", roomID, "WS监听服务启动中")
	// uid为主播的uid
	dq, err := acfundanmu.Init(int64(roomID), ACCookies)
	if err != nil {
		log.Println("[Danmaku]", roomID, "出错结束")
		return
	}
	dq.StartDanmu(ctx, false)
	for {
		if danmu := dq.GetDanmu(); danmu != nil {
			for _, d := range danmu {
				// 根据Type处理弹幕
				switch d := d.(type) {
				case *acfundanmu.Gift:
					var data = new(dataGiftStruct)
					data.Cmd = 3
					data.Data.Id = d.UserID
					data.Data.WebpPic = d.WebpPic
					data.Data.PngPic = d.PngPic
					data.Data.Timestamp = time.Now().Unix()
					data.Data.AuthorName = d.Nickname
					data.Data.Medal = d.Medal
					data.Data.GiftName = d.GiftName
					data.Data.Num = int(d.Count)
					var price = d.Value / 10
					if d.GiftName == "香蕉" {
						price = 0
					}
					data.Data.TotalCoin = int(price)
					var dataQ = new(Message)
					dataQ.RoomID = roomID
					dataQ.Data = data
					MessageQ.Enqueue(dataQ)
					//log.Println("Conn Gift", data)
					log.Printf("[Danmaku] %v, %s（%d）送出礼物 %s * %d，连击数：%d\n", roomID, d.Nickname, d.UserID, d.GiftName, d.Count, d.Combo)
				}
			}
		} else {
			log.Println("[Danmaku]", roomID, " 直播结束")
			return
		}
	}
}

func sendMysqlData(dataJson []byte, roomID int)  {
	defer func() {
		log.Println("[MysqlInsert]", "完成")
	}()
	any := jsoniter.Get(dataJson)
	var author_name = any.Get("data").Get("authorName").ToString()
	var author_id = any.Get("data").Get("id").ToString()
	var content = any.Get("data").Get("giftName").ToString()
	var num = any.Get("data").Get("num").ToString()
	var totalCoin = any.Get("data").Get("totalCoin").ToString()
	var timeStamp = any.Get("data").Get("timestamp").ToString()
	//`add_date`, `up_id`, `author_id`, `author_name`, `type`, `content`, `num`, `total`
	var dataString = fmt.Sprintf("INSERT INTO vup_danmaku_gift_data VALUES (%v, '%v', %v, '%v', %v, %v, %v)", roomID, author_name, author_id, content, num, totalCoin,timeStamp)
	//log.Printf("[Mysql] %v, %s\n", roomID, dataString)
	rows, err := Database_Mysql.Exec(dataString)
	if err != nil {
		log.Println("[MysqlInsert]", "更新失败：", err)
		return
	}
	rowCount, err := rows.RowsAffected()
	if err != nil {
		log.Println("[MysqlInsert]", "更新失败：", err)
	}
	log.Println("[MysqlInsert]", "更新成功，影响行数：", int(rowCount))
}