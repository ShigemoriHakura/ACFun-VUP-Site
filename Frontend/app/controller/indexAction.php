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
        $upListDataset = $this->upDetailDAO->query();
        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;
        foreach ($upListDataset as $k => $upData){
            if($rawData = $this->upRawDataDAO->filter(['uperid'=>$upData['uperid']])->order(array('up_date'=>'DESC'))->limit(1)->query()){
                $upData['rawData'] = $rawData[0];
                $upListDatasetColumn[$i] = $rawData[0]['followers'];
                $upListDatasets[$i] = $upData;
                $i ++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);
        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        return $this->display('main/index', array(
            'upListData' => $upListDatasets,
            'adminData' => $adminData
        ));
    }

}