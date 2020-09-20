<?php

namespace app\controller;
use App;
use biny\lib\Language;
use biny\lib\Mobile_Detect;
use Constant;

class customstreamAction extends baseAction
{
    /**
     * 自定义
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }

        $queryDay = 5;
        $detect = new Mobile_Detect;
        if ( $detect->isMobile() ) {
            $queryDay = 1;
        }

        $updata = [];
        $ups = $this->request->post('ups');
        if(is_array($ups) && count($ups) <= 5){
            foreach ($ups as $up){
                if($upDetail = $this->upDetailDAO->filter(['uperid'=>$up])->find()) {
                    $uplist = array(
                        "name" => $upDetail['nowName'],
                        "data" => []
                    );
                    $upRawDatas = $this->upRawDataDAO->filter([
                        'uperid' => $up,
                        '>=' => array('up_date' => time() - 60 * 60 * 24 * $queryDay)
                    ])->query();
                    if($upRawDatas){
                        foreach ($upRawDatas as $v){
                            $uplist["data"][] = array((int)$v['up_date'] * 1000, $v['followers']);
                        }
                        $updata[] = $uplist;
                    }
                }
            }
        }else{
            $ups = array();
        }

        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            '<'=>array('add_date'=> $todayTimestamp)
        ])->query();

        return $this->display('stream/customstream', array(
            'adminData' => $adminData,
            'upList' => $upListDataset,
            'upSelected' => $ups,
            'upData' => $updata
        ));
    }

}