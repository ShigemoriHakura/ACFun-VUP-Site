<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class indexAction extends baseAction
{
    /**
     * 首页
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);

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

        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        return $this->display('main/index', array(
            'upListCount' => $upListCount,
            'upListTodayCount' => $upListTodayCount,
            'upMedalCount' => $upMedalCount,
            'upLiveListTodayCount' => $upLiveListTodayCount,
            'adminData' => $adminData
        ));
    }

}