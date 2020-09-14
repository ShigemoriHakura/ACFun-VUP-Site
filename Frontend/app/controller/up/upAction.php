<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class upAction extends baseAction
{
    /**
     * 重定向首页
     */
    public function action_index()
    {
        $this->response->redirect('/');
    }

    public function getMsecToMescdate($msectime)
    {
        $msectime = $msectime * 0.001;
        if (strstr($msectime, '.')) {
            sprintf("%01.3f", $msectime);
            list($usec, $sec) = explode(".", $msectime);
            $sec = str_pad($sec, 3, "0", STR_PAD_RIGHT);
        } else {
            $usec = $msectime;
            $sec = "000";
        }
        $date = date("Y-m-d H:i:s", $usec);
        return $mescdate = str_replace('x', $sec, $date);
    }

    public function action_detail($upid)
    {
        if($upid){
            if(!Language::getLanguage()){
                Language::setLanguage('cn', Constant::month);
            }
            $lang = $this->get('lang');
            $lang && Language::setLanguage($lang, Constant::month);
            if ($upDetail = $this->upDetailDAO->filter(['uperid'=>$upid])->find()){
                if ($this->upRawDataDAO->filter(['uperid'=>$upid])->count() > 2){
                    $upRawData = $this->upRawDataDAO->filter(['uperid'=>$upid])->order(array('up_date'=>'DESC'))->find();
                    $upRawDatas = $this->upRawDataDAO->filter([
                        'uperid'=>$upid,
                        '>='=>array('up_date'=> time() - 60 * 60 * 24 * 5)
                    ])->query();
                    $chartData = [];
                    $contentData = [];
                    foreach ($upRawDatas as $raw){
                        $chartData[] = array((int)$raw['up_date'] * 1000, $raw['followers']);
                        $contentData[] = array((int)$raw['up_date'] * 1000, $raw['contentCount']);
                    }
                    $registerDate = date('Y-m-d H:i:s', $upDetail['add_date']);
                    $acRegisterDate = $this->getMsecToMescdate($upDetail['registerTime']);
                    $updatedDate = date('Y-m-d H:i:s', $upRawData['up_date']);
                    $adminData = [];
                    if(App::$model->Admin->exist()){
                        $adminData = App::$model->Admin->values();
                    }
                    return $this->display('up/upDetail', array(
                        'adminData'    => $adminData,
                        'upDetail'     => $upDetail,
                        'upRawData'    => $upRawData,
                        'registerDate' => $registerDate,
                        'acRegisterDate' => $acRegisterDate,
                        'updatedDate'  => $updatedDate,
                        'chartData'    => $chartData,
                        'contentData'    => $contentData,
                        'upID'         => $upid,
                    ));
                }
                return $this->display('up/upDetail_NoData');
            } else {
                return $this->display('up/upDetail_404');
            }
        }else{
            $this->response->redirect('/');
        }
    }

}