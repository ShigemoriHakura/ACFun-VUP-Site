<?php

namespace app\controller;
use App;
use biny\lib\Language;
use biny\lib\Mobile_Detect;
use Constant;

class giftAction extends baseAction
{
  public function action_detail($upid, $day)
  {
    if($upid){
      if ($upDetail = $this->upDetailDAO->filter(['uperid'=>$upid])->find()) {
          $giftDetail = $this->upGiftDataDAO->filter(['roomId'=>$upid])->order(array('add_date'=>'ASC'))->query();
          return $this->display('gift/giftDetail', array(
              'giftDetail' => $giftDetail,
              'upDetail' => $upDetail,
              'uperid' => $upid
          ));
      }else{
          return $this->display('up/upDetail_404');
      }
  }else{
      $this->response->redirect('/');
  }
  }
}