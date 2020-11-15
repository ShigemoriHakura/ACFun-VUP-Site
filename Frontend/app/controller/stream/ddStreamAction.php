<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class ddStreamAction extends baseAction
{
    /**
     * 每日
     */
    public function action_index()
    {
        $giftDetail = $this->streamService->getDdStreamToday();
        $totalPrice = 0;
        $totalNum = 0;
        foreach($giftDetail as $value){
            $totalPrice += $value["price"];
            $totalNum += $value["num"];
        }
        return $this->display('stream/ddStream', array(
            'ddDetail' => $giftDetail,
            'dayTimestamp' => strtotime(date('Y-m-d')),
            'totalPrice' => $totalPrice,
            'totalNum' => $totalNum
        ));
    }

    public function action_prev($day){
        if(!$day || $day <= 0){
            $this->response->redirect('/dd/prev/1');
        }
        $todayTimestamp = strtotime(date('Y-m-d')) - ($day - 1) * 86400;
        $ydayTimestamp = strtotime(date('Y-m-d')) - ($day - 1) * 86400 - 86400;
       
        $giftDetail = $this->upGiftDataDAO->filter([
            '>='=>array('add_date'=> $ydayTimestamp),
            '<='=>array('add_date'=> $todayTimestamp)
        ])->query();

        $giftDetailSum = array();
        $totalPrice = 0;
        $totalNum = 0;
        foreach($giftDetail as $value){
            $totalPrice += $value["price"];
            $totalNum += $value["num"];
            if(isset($giftDetailSum[$value["senderId"]])){
                $giftDetailSum[$value["senderId"]]["price"] += $value["price"];
            }else{
                $giftDetailSum[$value["senderId"]] =  $value;
            }
        }
        $giftDetailSumCS = array_column($giftDetailSum, 'price');
        array_multisort($giftDetailSumCS, SORT_DESC, $giftDetailSum);
        
        return $this->display('stream/ddStream', array(
            'ddDetail' => $giftDetailSum,
            'dayTimestamp' => $todayTimestamp - 1,
            'totalPrice' => $totalPrice,
            'totalNum' => $totalNum
        ));
    }
}