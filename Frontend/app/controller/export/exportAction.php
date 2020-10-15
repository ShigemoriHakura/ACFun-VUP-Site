<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class exportAction extends baseAction
{
    /**
     * Export
     */
    public function action_index()
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);

        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }

        $month = date('Y-m');
        return $this->display('export/index', array(
            'adminData' => $adminData,
            'month' => $month
        ));
    }

    public function action_output(){
        $month = $this->request->post('month');
        $type = $this->request->post('type');
        $valueType = $this->request->post('valueType');
        if(!$type || !$month || !$valueType){
            $this->response->redirect('/export');
        }
        $timestamp = strtotime($month);
        if(!$timestamp){
            $this->response->redirect('/export');
        }

        $upDetails = [];
        $csvDatas = [];
        $lastDate = strtotime("$month +1 month");
        
        switch($valueType){
            case "followers":
                $cronLatestData = $this->upCronDataDAO->filter([
                    '>='=>array('add_date'=> $timestamp),
                    '<='=>array('add_date'=> $lastDate),
                ])->order(array('add_date'=>'ASC'))->query();
                foreach ($cronLatestData as $k => $upData) {
                    if($upDetails[$upData['uperid']]){
                        $upd = $upDetails[$upData['uperid']];
                        $csvArray = array(
                            "name" => $upd['nowName'],
                            "type" => "粉丝总数",
                            "value" => $upData["followers"],
                            "date" => date('Y/m/d', $upData['add_date'])
                        );
                        $csvDatas[] = $csvArray;
                    }else{
                        $rawLatestData = $this->upDetailDAO->filter([
                            'uperid'=>$upData['uperid']
                        ])->find();
                        if($rawLatestData) {
                            $upDetails[$upData['uperid']] = $rawLatestData;
                            $csvArray = array(
                                "name" => $rawLatestData['nowName'],
                                "type" => "粉丝总数",
                                "value" => $upData["followers"],
                                "date" => date('Y/m/d', $upData['add_date'])
                            );
                            $csvDatas[] = $csvArray;
                        }
                    }
        
                }
                break;
            case "followersChange":
                $cronLatestData = $this->upCronDataDAO->filter([
                    '>='=>array('add_date'=> $timestamp),
                    '<='=>array('add_date'=> $lastDate),
                ])->order(array('add_date'=>'ASC'))->query();
                foreach ($cronLatestData as $k => $upData) {
                    if($upDetails[$upData['uperid']]){
                        $upd = $upDetails[$upData['uperid']];
                        $csvArray = array(
                            "name" => $upd['nowName'],
                            "type" => "粉丝增量",
                            "value" => $upData["followers_change"],
                            "value1" => $upData["followers"],
                            "date" => date('Y/m/d', $upData['add_date'])
                        );
                        $csvDatas[] = $csvArray;
                    }else{
                        $rawLatestData = $this->upDetailDAO->filter([
                            'uperid'=>$upData['uperid']
                        ])->find();
                        if($rawLatestData) {
                            $upDetails[$upData['uperid']] = $rawLatestData;
                            $csvArray = array(
                                "name" => $rawLatestData['nowName'],
                                "type" => "粉丝增量",
                                "value" => $upData["followers_change"],
                                "value1" => $upData["followers"],
                                "date" => date('Y/m/d', $upData['add_date'])
                            );
                            $csvDatas[] = $csvArray;
                        }
                    }
        
                }
                break;
            case "onlineCount":
                $cronLatestData = $this->upLiveDataCronDAO->filter([
                    '>='=>array('add_date'=> $timestamp),
                    '<='=>array('add_date'=> $lastDate),
                ])->order(array('add_date'=>'ASC'))->query();
                foreach ($cronLatestData as $k => $upData) {
                    if($upDetails[$upData['uperid']]){
                        $upd = $upDetails[$upData['uperid']];
                        $csvArray = array(
                            "name" => $upd['nowName'],
                            "type" => "观众峰值",
                            "value" => $upData["onlineCount"],
                            "date" => date('Y/m/d', $upData['add_date'])
                        );
                        $csvDatas[] = $csvArray;
                    }else{
                        $rawLatestData = $this->upDetailDAO->filter([
                            'uperid'=>$upData['uperid']
                        ])->find();
                        if($rawLatestData) {
                            $upDetails[$upData['uperid']] = $rawLatestData;
                            $csvArray = array(
                                "name" => $rawLatestData['nowName'],
                                "type" => "观众峰值",
                                "value" => $upData["onlineCount"],
                                "date" => date('Y/m/d', $upData['add_date'])
                            );
                            $csvDatas[] = $csvArray;
                        }
                    }
        
                }
                break;
            
        }
        
        switch ($type){
            case "d3":
                $filename = "D3.csv";
                $fileData = "name,type,value,date\n";
                foreach ($csvDatas as $value) {
                    $temp = $value['name'] . ',' .
                        $value['type'] . ',' .
                        $value['value'] . ',' .
                        $value['date'];
                    $fileData .= $temp . "\n";
                }
                header("Content-type:text/csv");
                header("Content-Disposition:attachment;filename=" . $filename);
                header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
                header('Expires:0');
                header('Pragma:public');
                echo $fileData;
                break;
            default:
                $this->response->redirect('/export');
                break;
        }

    }


}