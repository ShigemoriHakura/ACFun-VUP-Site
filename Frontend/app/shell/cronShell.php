<?php

namespace app\shell;
use biny\lib\Shell;

class cronShell extends Shell
{

    //默认路由index
    public function action_index()
    {
        //在00：00后运行，时间戳会是0点的-1秒，也就是昨日的23：59：59的数据
        $todayTimestamp = strtotime(date('Y-m-d'));
        //$todayTimestamp = strtotime("2020-9-14");
        $ydayTimestamp = $todayTimestamp - 86400;
        $upListDataset = $this->upDetailDAO->filter([
            '<'=>array('add_date'=> $todayTimestamp)
        ])->query();

        $updateSet = [];
        foreach ($upListDataset as $k => $upData){
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '<='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            $rawOldestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $ydayTimestamp)
            ])->order(array('up_date'=>'ASC'))->limit(1)->query();
            if($rawLatestData && $rawOldestData){
                $followersAdded = $rawLatestData[0]['followers'] - $rawOldestData[0]['followers'];
                $followingAdded = $rawLatestData[0]['following'] - $rawOldestData[0]['following'];
                $updateSet[] = array(
                    "uperid"    => $upData['uperid'],
                    "add_date"  => $todayTimestamp - 1,
                    "followers" => $rawLatestData[0]['followers'],
                    "following" => $rawLatestData[0]['following'],
                    "followers_change" => $followersAdded,
                    "following_change" => $followingAdded,
                );
            }
        }
        $result = $this->upCronDataDAO->addList($updateSet);
        return json_encode(array("result" => $result, "data" => $updateSet));
    }
}