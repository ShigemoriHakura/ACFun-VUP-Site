<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class newStreamAction extends baseAction
{
    /**
     * 新收录
     */
    public function action_index()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            '>'=>array('add_date'=> $todayTimestamp)
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
        return $this->display('stream/newStream', array(
            'upListData' => $upListDatasets,
            'dayTimestamp' => $todayTimestamp
        ));
    }

}