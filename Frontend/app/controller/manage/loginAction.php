<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class loginAction extends baseAction
{
    /**
     * 登录
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        if (App::$model->Admin->exist()){
            $this->response->redirect('/');
        }
        $username = $this->param('username');
        $password = $this->param('password');
        if (!$username | !$password){
            return $this->display('manage/login');
        }
        if ($user = $this->adminDAO->filter(['username'=>$username])->find()){
            if($user['password'] == md5(sha1(md5($password)))){
                App::$model->Admin($user['id'])->login($user['id']);
            }else{
                return $this->display('manage/login' , array(
                    "message" => "X",
                ));
            }
        } else {
            return $this->display('manage/login' , array(
                "message" => "X",
            ));
        }
        if ($lastUrl = App::$base->session->lastUrl){
            unset(App::$base->session->lastUrl);
            $this->response->redirect($lastUrl);
        } else {
            $this->response->redirect('/');
        }
    }

}