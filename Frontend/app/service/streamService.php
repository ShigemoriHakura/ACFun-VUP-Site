<?php

namespace app\service;

use biny\lib\Service;
use App;

class streamService extends Service
{
    public function getUpStreamToday()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            'enabled' => 1,
            '<'=>array('add_date'=> $todayTimestamp)
        ])->query();
        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;
        foreach ($upListDataset as $k => $upData){
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            $rawOldestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'ASC'))->limit(1)->query();
            if($rawLatestData && $rawOldestData){
                $followersAdded = $rawLatestData[0]['followers'] - $rawOldestData[0]['followers'];
                $upListDatasetColumn[$i] = $followersAdded;
                $upData['rawData'] = $rawLatestData[0];
                $upData['followersAdded'] = $followersAdded;
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        return $upListDatasets;
    }

    public function getDailyStreamToday()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            'enabled' => 1,
            '<'=>array('add_date'=> $todayTimestamp)
        ])->query();

        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;

        foreach ($upListDataset as $k => $upData){
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            $rawOldestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'ASC'))->limit(1)->query();
            if($rawLatestData && $rawOldestData){
                $followersAdded = $rawLatestData[0]['followers'] - $rawOldestData[0]['followers'];
                $upListDatasetColumn[$i] = $rawLatestData[0]['followers']; //排序标准
                $upData['rawData'] = $rawLatestData[0];
                $upData['followersAdded'] = $followersAdded;
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        return $upListDatasets;
    }

    public function getDdStreamToday()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $giftDetail = $this->upGiftDataDAO->filter([
            '>='=>array('add_date'=> $todayTimestamp)
        ])->query();

        $giftDetailSum = array();
        foreach($giftDetail as $value){
            if(isset($giftDetailSum[$value["senderId"]])){
                $giftDetailSum[$value["senderId"]]["price"] += $value["price"];
            }else{
                $giftDetailSum[$value["senderId"]] =  $value;
            }
        }
        $giftDetailSumCS = array_column($giftDetailSum, 'price');
        array_multisort($giftDetailSumCS, SORT_DESC, $giftDetailSum);

        return $giftDetailSum;
    }

}