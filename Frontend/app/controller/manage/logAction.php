<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class logAction extends baseAction
{
    /**
     * 更新日志
     */
    public function action_update()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        $adminData = App::$model->Admin->values();
        $logDataset = $this->logDAO->order(array('add_date'=>'DESC'))->query();
        return $this->display('manage/log', array(
            'adminData' => $adminData,
            'logDataset' => $logDataset
        ));
    }

}