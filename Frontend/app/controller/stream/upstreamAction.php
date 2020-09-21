<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class upstreamAction extends baseAction
{
    /**
     * 急上升
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);

        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
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
        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        return $this->display('stream/upstream', array(
            'upListData' => $upListDatasets,
            'adminData' => $adminData
        ));
    }

    public function action_prev($day){
        if(!$day || $day <= 0){
            $this->response->redirect('/ups/prev/1');
        }

        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
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
                $upListDatasetColumn[$i] = $upData['followers_change']; //排序标准
                $rawLatestData[0]['followers'] = $upData['followers'];
                $upData['rawData'] = $rawLatestData[0];
                $upData['followersAdded'] = $upData['followers_change'];
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        return $this->display('stream/upstream', array(
            'upListData' => $upListDatasets,
            'adminData' => $adminData
        ));
    }
}