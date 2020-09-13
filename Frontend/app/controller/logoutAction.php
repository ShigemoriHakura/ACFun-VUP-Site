<?php

namespace app\controller;
use App;
use Constant;

class logoutAction extends baseAction
{
    /**
     * 登录
     */
    public function action_index()
    {
        //App::$base->session->userId = 0;
        if (App::$model->Admin->exist()){
            App::$model->Admin->loginOut();
        }
        if ($lastUrl = App::$base->session->lastUrl){
            unset(App::$base->session->lastUrl);
            $this->response->redirect($lastUrl);
        } else {
            $this->response->redirect('/');
        }
    }

}