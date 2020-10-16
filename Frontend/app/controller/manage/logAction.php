<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class logAction extends baseAction
{
    /**
     * 更新日志
     */
    public function action_update()
    {
        $logDataset = $this->logDAO->order(array('add_date'=>'DESC'))->query();
        return $this->display('manage/log', array(
            'logDataset' => $logDataset
        ));
    }

}