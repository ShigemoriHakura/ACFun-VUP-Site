<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class dailyStreamAction extends baseAction
{
    /**
     * 每日
     */
    public function action_index()
    {

        return $this->display('stream/dailyStream', array(
            'upListData' => $this->streamService->getDailyStreamToday(),
            'dayTimestamp' => strtotime(date('Y-m-d'))
        ));
    }

    public function action_prev($day){
        if(!$day || $day <= 0){
            $this->response->redirect('/daily/prev/1');
        }
        $todayTimestamp = strtotime(date('Y-m-d')) - ($day - 1) * 86400;
        $cronLatestData = $this->upCronDataDAO->filter([
            '='=>array('add_date'=> $todayTimestamp - 1)
        ])->order(array('add_date'=>'DESC'))->query();

        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;

        foreach ($cronLatestData as $k => $upData){
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upData['uperid'],
                '>='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            if($rawLatestData){
                $upListDatasetColumn[$i] = $upData['followers']; //排序标准
                $rawLatestData[0]['followers'] = $upData['followers'];
                $upData['rawData'] = $rawLatestData[0];
                $upData['followersAdded'] = $upData['followers_change'];
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        return $this->display('stream/dailyStream', array(
            'upListData' => $upListDatasets,
            'dayTimestamp' => $todayTimestamp - 1
        ));
    }
}