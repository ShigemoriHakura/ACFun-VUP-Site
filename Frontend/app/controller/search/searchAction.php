<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class searchAction extends baseAction
{
    /**
     * 搜索
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->request->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }

        $keyword = $this->request->get('keyword');
        if($keyword) {
            $uperResult = $this->searchKeyword($keyword);
            return $this->display('search/search', array(
                'uperResult' => $uperResult,
                'adminData' => $adminData
            ));
        }
        return $this->display('search/index', array(
            'adminData' => $adminData
        ));
    }

    public function action_search($keyword)
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->request->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        if($keyword) {
            $uperResult = $this->searchKeyword($keyword);
            return $this->display('search/search', array(
                'uperResult' => $uperResult,
                'adminData' => $adminData
            ));
        }
    }

    function searchKeyword($keyword){
        $keyword = urldecode($keyword);
        $uperResult = $this->upDetailDAO->merge(array(
            '__like__'=>array(
                'name'=>array($keyword),
                'uperid'=>array($keyword),
                'nowName'=>array($keyword),
            )
        ))->query();
        return $uperResult;
    }
}