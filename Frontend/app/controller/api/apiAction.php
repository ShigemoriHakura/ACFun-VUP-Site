<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class apiAction extends baseAction
{
    /**
     * API
     */
    public function action_index()
    {
        return $this->displayJson(1, "Hello world");
    }

    public function action_up_detail($upid)
    {
        if($upid){
            $date = $this->request->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) + 86400;
            if($date){
                $todayTimestamp = strtotime(date('Y-m-d', $date)) + 86400;
            }
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upid,
                '<='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            return $this->displayJson(1, $rawLatestData);
        }else{
            return $this->displayJson(0, "no uperid");
        }
    }

    public function action_up_cron($upid)
    {
        if($upid){
            $date = $this->request->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) - 1;
            if($date){
                $todayTimestamp = strtotime(date('Y-m-d', $date));
            }
            $cronLatestData = $this->upCronDataDAO->filter([
                'uperid'=>$upid,
                '<='=>array('add_date'=> $todayTimestamp)
            ])->order(array('add_date'=>'DESC'))->limit(1)->query();
            return $this->displayJson(1, $cronLatestData);
        }else{
            return $this->displayJson(0, "no uperid");
        }
    }

    public function action_up_search($keyword){
        return $this->displayJson(1, $this->statisticsService->getUpDetailsByKeyword($keyword));
    }

    public function action_stream_upStream(){
        return $this->displayJson(1, $this->streamService->getUpStreamToday());
    }

    public function action_stream_dailyStream(){
        return $this->displayJson(1, $this->streamService->getDailyStreamToday());
    }
}