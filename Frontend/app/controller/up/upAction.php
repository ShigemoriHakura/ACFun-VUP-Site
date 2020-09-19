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
                    $upRawLiveDatas = $this->upRawLiveDataDAO->filter([
                        'uperid'=>$upid,
                        '>='=>array('up_date'=> time() - 60 * 60 * 24 * 5)
                    ])->query();
                    $chartData = [];
                    $contentData = [];
                    foreach ($upRawDatas as $raw){
                        $chartData[] = array((int)$raw['up_date'] * 1000, $raw['followers']);
                        $contentData[] = array((int)$raw['up_date'] * 1000, $raw['contentCount']);
                    }
                    $chartLiveData = [];
                    $chartLiveLoveData = [];
                    $chartLiveUserData = [];
                    foreach ($upRawLiveDatas as $raw){
                        $chartLiveData[] = array((int)$raw['up_date'] * 1000, $raw['isLive']);
                        $chartLiveLoveData[] = array((int)$raw['up_date'] * 1000, $raw['likeCount']);
                        $chartLiveUserData[] = array((int)$raw['up_date'] * 1000, $raw['onlineCount']);
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
                        'contentData'  => $contentData,
                        'chartLiveData'     => $chartLiveData,
                        'chartLiveLoveData' => $chartLiveLoveData,
                        'chartLiveUserData' => $chartLiveUserData,
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

    public function action_feed($upid)
    {
        if($upid){
            if(!Language::getLanguage()){
                Language::setLanguage('cn', Constant::month);
            }
            $lang = $this->get('lang');
            $lang && Language::setLanguage($lang, Constant::month);
            if ($upDetail = $this->upDetailDAO->filter(['uperid'=>$upid])->find()) {
                $adminData = [];
                if (App::$model->Admin->exist()) {
                    $adminData = App::$model->Admin->values();
                }
                $jsonDataReturn = [];
                $url = "https://api-new.app.acfun.cn/rest/app/feed/profile?userId=" . $upid . "&count=100";
                $data = $this->curl_file_get_contents($url);
                if ($jsonData = json_decode($data, true)) {
                    if (!is_null($jsonData['feedList'])) {
                        $jsonDataReturn = $jsonData['feedList'];
                    }
                }

                return $this->display('up/upFeed', array(
                    'adminData' => $adminData,
                    'jsonDataReturn' => $jsonDataReturn,
                    'uperid' => $upid
                ));
            }else{
                return $this->display('up/upDetail_404');
            }
        }else{
            $this->response->redirect('/');
        }
    }

    public function curl_file_get_contents($durl){
        // header传送格式
        $headers = array(
        );
        $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";

        // 初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT,$user_agent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        // 设置url路径
        curl_setopt($curl, CURLOPT_URL, $durl);
        // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
        // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
        // 添加头信息
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // CURLINFO_HEADER_OUT选项可以拿到请求头信息
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        // 不验证SSL
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 执行
        $data = curl_exec($curl);
        // 打印请求头信息
//        echo curl_getinfo($curl, CURLINFO_HEADER_OUT);
        // 关闭连接
        curl_close($curl);
        // 返回数据
        return $data;
    }


}