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
            'medalDataset' => $MedalDataset,
        ));
    }

    public function action_search($keyword)
    {
        if($keyword) {
            $medalResult = $this->statisticsService->getMedalsByKeyword($keyword);
            return $this->display('medal/search', array(
                'medalResult' => $medalResult,
                'keyword' => $keyword,
            ));
        }else{
            return $this->display('medal/index');
        }
    }
}