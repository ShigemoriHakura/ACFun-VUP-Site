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
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        return json_encode($result);
    }

    public function action_up_detail($upid)
    {
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        if($upid){
            $date = $this->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) + 86400;
            if($date){
                $todayTimestamp = strtotime(date('Y-m-d', $date)) + 86400;
            }
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid'=>$upid,
                '<='=>array('up_date'=> $todayTimestamp)
            ])->order(array('up_date'=>'DESC'))->limit(1)->query();
            $result["data"] = $rawLatestData;
        }else{
            $result["data"] = "no uperid";
        }
        return json_encode($result);
    }

    public function action_up_cron($upid)
    {
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        if($upid){
            $date = $this->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) - 86400;
            if($date){
                $todayTimestamp = strtotime(date('Y-m-d', $date));
            }
            $cronLatestData = $this->upCronDataDAO->filter([
                'uperid'=>$upid,
                '<='=>array('add_date'=> $todayTimestamp)
            ])->order(array('add_date'=>'DESC'))->limit(1)->query();
            $result["data"] = $cronLatestData;
        }else{
            $result["data"] = "no uperid";
        }
        return json_encode($result);
    }
}