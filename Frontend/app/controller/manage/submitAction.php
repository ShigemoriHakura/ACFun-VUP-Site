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
        $status = false;
        if(App::$model->Admin->exist()){
            $form = $this->getForm('systemUP');
            if (!$form->check()){
                return $this->display('manage/submit', array(
                    'status' => false
                ));
            }
            $uperid = $form->uperid;
            $name = $form->name;
            $sets = array(
                'uperid'    => $uperid,
                'name'      => $name,
                'add_date'  => time(),
                'last_date' => 0,
                'enabled'   => 1
            );
            $status = $this->upDetailDAO->add($sets, false);
        }
        return $this->display('manage/submit', array(
            'status' => $status
        ));
    }

    public function action_log()
    {
        $status = false;
        if(App::$model->Admin->exist()) {
            $form = $this->getForm('systemLog');
            if (!$form->check()) {
                return $this->display('manage/submit_log', array(
                    'status' => true
                ));
            }
            $content = $form->content;
            $level = $form->level;
            $sets = array(
                'level' => $level,
                'content' => $content,
                'add_date' => time(),
            );
            $status = $this->logDAO->add($sets, false);
        }
        return $this->display('manage/submit_log', array(
            'status' => $status
        ));
    }

}