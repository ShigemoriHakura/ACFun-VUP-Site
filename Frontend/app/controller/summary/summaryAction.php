<?php

namespace app\controller;
use App;

class summaryAction extends baseAction
{
    /**
     * 总报
     */
    public function action_index($month)
    {
      if($month){
        $timestamp = strtotime($month);
        $lastDate = strtotime("$month +1 month");
        $giftDetail = $this->upGiftDataDAO->filter([
            '>='=>array('add_date'=> $timestamp),
            '<='=>array('add_date'=> $lastDate)
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
        
        //var_dump($giftDetailSum);
        return $this->display('summary/summary', array(
            'month' => $month,
            'ddDetail' => $giftDetailSum,
            'totalPrice' => $totalPrice,
            'totalNum' => $totalNum
        ));
      }else{
        $month = date('Y-m');
        return $this->display('summary/index', array(
            'month' => $month
        ));
      }
    }

}