<?php

namespace app\controller;
use App;
use biny\lib\Language;
use biny\lib\Mobile_Detect;
use Constant;

class giftAction extends baseAction
{
  public function action_detail($upid, $start, $end)
  {
    if($upid){
        if ($upDetail = $this->upDetailDAO->filter(['uperid'=>$upid])->find()) {
            $giftDetail = $this->upGiftDataDAO->filter([
                'roomId' => $upid,
                '>=' => array('add_date'=> $start),
                '<=' => array('add_date'=> $end)
                ])
            ->order(array('add_date'=>'ASC'))->query();
            $totalPrice = 0;
            $totalNum = 0;
            foreach($giftDetail as $value){
                $totalPrice += $value["price"];
                $totalNum += $value["num"];
            }
            return $this->display('gift/giftDetail', array(
                'giftDetail' => $giftDetail,
                'upDetail' => $upDetail,
                'uperid' => $upid,
                'totalPrice' => $totalPrice,
                'totalNum' => $totalNum
            ));
        }else{
            return $this->display('up/upDetail_404');
        }
    }else{
        $this->response->redirect('/');
    }
  }

  public function action_sum($upid, $start, $end)
  {
    if($upid){
        if ($upDetail = $this->upDetailDAO->filter(['uperid'=>$upid])->find()) {
            $giftDetail = $this->upGiftDataDAO->filter([
                'roomId' => $upid,
                '>=' => array('add_date'=> $start),
                '<=' => array('add_date'=> $end)
                ])
            ->order(array('add_date'=>'ASC'))->query();
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
            return $this->display('gift/giftSum', array(
                'giftDetail' => $giftDetailSum,
                'upDetail' => $upDetail,
                'uperid' => $upid,
                'totalPrice' => $totalPrice,
                'totalNum' => $totalNum
            ));
        }else{
            return $this->display('up/upDetail_404');
        }
    }else{
        $this->response->redirect('/');
    }
  }
}