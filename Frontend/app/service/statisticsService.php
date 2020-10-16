<?php
/*
 * @Date: 2020-10-16 22:24:52
 * @LastEditors: kanoyami
 * @LastEditTime: 2020-10-16 23:49:00
 */

namespace app\service;

use biny\lib\Service;
use App;

class statisticsService extends Service
{
    public function fansTopTen()
    {
        return $this->upRawDataDAO->order(array('followers' => 'DESC'))->limit(10)->query(array('uperid', 'name', "followers"), 'uperid');
    }
    public function getUpDetailsByUpName($upname)
    {
        return $this->upRawDataDAO->filter(array('name' => $upname))->order(array('up_date' => 'DESC'))->find();
    }
}
