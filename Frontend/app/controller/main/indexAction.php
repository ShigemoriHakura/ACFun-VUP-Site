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
        $upListCount = $this->upDetailDAO->count();
        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        return $this->display('main/index', array(
            'upListCount' => $upListCount,
            'adminData' => $adminData
        ));
    }

}