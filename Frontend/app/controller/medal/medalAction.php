<?php

namespace app\controller;
use App;
use biny\lib\Language;
use biny\lib\Mobile_Detect;
use Constant;

class medalAction extends baseAction
{
    /**
     * 重定向首页
     */
    public function action_index()
    {
        $this->response->redirect('/medal/list');
    }

    public function action_list(){
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);
        $adminData = App::$model->Admin->values();
        $MedalDataset = $this->upMedalDAO->query();

        $upIDName = [];
        $upDataset = $this->upDetailDAO->query();
        foreach ($upDataset as $up){
            $upIDName[$up['uperid']] = array(
                "name" => $up['name'],
                "nowName" => $up['nowName']
            );
        }
        foreach ($MedalDataset as $k => $medal){
            $medal["up"] = $upIDName[$medal["uperid"]];
            $MedalDataset[$k] = $medal;
        }
        return $this->display('medal/list', array(
            'adminData' => $adminData,
            'medalDataset' => $MedalDataset,
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
            $medalResult = $this->searchKeyword($keyword);
            return $this->display('medal/search', array(
                'medalResult' => $medalResult,
                'keyword' => $keyword,
                'adminData' => $adminData
            ));
        }else{
            return $this->display('medal/index', array(
                'adminData' => $adminData
            ));
        }
    }

    function searchKeyword($keyword){
        $keyword = urldecode($keyword);
        $medalResult = $this->upMedalDAO->merge(array(
            '__like__'=>array(
                'clubName'=>array($keyword),
                'uperid'=>array($keyword),
            )
        ))->query();
        if(count($medalResult) > 0){
            $upIDName = [];
            $upDataset = $this->upDetailDAO->query();
            foreach ($upDataset as $up){
                $upIDName[$up['uperid']] = array(
                    "name" => $up['name'],
                    "nowName" => $up['nowName']
                );
            }
            foreach ($medalResult as $k => $medal){
                $medal["up"] = $upIDName[$medal["uperid"]];
                $medalResult[$k] = $medal;
            }
        }
        return $medalResult;
    }

}