<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class submitAction extends baseAction
{
    /**
     * 提交数据
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        if (!App::$model->Admin->exist()){
            $this->response->redirect('/');
        }
        $adminData = App::$model->Admin->values();
        $uperid = $this->param('uperid');
        $name   = $this->param('name');
        if (!$uperid | !$name){
            return $this->display('main/submit', array(
                'adminData' => $adminData,
                'status' => true
            ));
        }else{
            $sets = array(
                'uperid'    => $uperid,
                'name'      => $name,
                'add_date'  => time(),
                'last_date' => 0,
                'enabled'   => 1
            );
            // false 时返回true/false
            $status = $this->upDetailDAO->add($sets, false);
            return $this->display('main/submit', array(
                'adminData' => $adminData,
                'status' => $status
            ));
        }
    }

}