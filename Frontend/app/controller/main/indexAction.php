<?php

namespace app\controller;
use App;

class indexAction extends baseAction
{
    /**
     * 首页
     */
    public function action_index()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListCount = $this->upDetailDAO->count();
        $upListTodayCount = $this->upDetailDAO->filter([
            '>='=>array('add_date'=> $todayTimestamp)
        ])->count();
        
        $upMedalCount = $this->upMedalDAO->count();
        
        $upLiveListTodayCount = count($this->upRawLiveDataDAO->filter([
            'isLive'=>1,
            '>='=>array('up_date'=> $todayTimestamp)
        ])->distinct('uperid'));

        return $this->display('main/index', array(
            'upListCount' => $upListCount,
            'upListTodayCount' => $upListTodayCount,
            'upMedalCount' => $upMedalCount,
            'upLiveListTodayCount' => $upLiveListTodayCount,
        ));
    }

}