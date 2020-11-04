<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class liveStreamAction extends baseAction
{
    /**
     * 每日
     */
    public function action_index()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            '<'=>array('add_date'=> $todayTimestamp)
        ])->query();

        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;


        $upLiveListToday = $this->upRawLiveDataDAO->filter([
            'isLive'=>1,
            '>='=>array('up_date'=> $todayTimestamp)
        ])->distinct('uperid');
        
        $newArray = array();
        foreach ($upLiveListToday as $k => $lived){
            $newArray[$lived["uperid"]] = $lived["uperid"];
        }
        
        foreach ($upListDataset as $k => $upData){
            if($newArray[$upData['uperid']] == $upData['uperid']){
                $rawLatestData = $this->upRawLiveDataDAO->filter([
                    'uperid'=> $upData['uperid'],
                    'isLive'=> 1,
                    '>='=>array('up_date'=> $todayTimestamp)
                ])->max('onlineCount');
                if($rawLatestData){
                    $upListDatasetColumn[$i] = $rawLatestData; //排序标准
                    $upData['onlineCount'] = $rawLatestData;
                    $upListDatasets[$i] = $upData;
                    $i ++;
                }
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        return $this->display('stream/liveStream', array(
            'upListData' => $upListDatasets,
            'dayTimestamp' => $todayTimestamp
        ));
    }

    public function action_prev($day){
        if(!$day || $day <= 0){
            $this->response->redirect('/live/prev/1');
        }

        $todayTimestamp = strtotime(date('Y-m-d')) - ($day - 1) * 86400;
        $cronLatestData = $this->upLiveDataCronDAO->filter([
            '='=>array('add_date'=> $todayTimestamp - 1)
        ])->order(array('add_date'=>'DESC'))->query();

        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;

        foreach ($cronLatestData as $k => $upData){
            $rawLatestData = $this->upDetailDAO->filter([
                'uperid'=>$upData['uperid'],
            ])->find();
            if($rawLatestData){
                $upListDatasetColumn[$i] = $upData['onlineCount']; //排序标准
                $upData['nowName'] = $rawLatestData['nowName'];
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);

        return $this->display('stream/liveStream', array(
            'upListData' => $upListDatasets,
            'dayTimestamp' => $todayTimestamp - 1
        ));
    }
}