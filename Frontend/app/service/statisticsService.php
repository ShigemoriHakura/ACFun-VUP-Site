<?php
/*
 * @Date: 2020-10-16 22:24:52
 * @LastEditors: kanoyami
 * @LastEditTime: 2020-10-17 01:05:59
 */

namespace app\service;

use biny\lib\Service;
use App;

class statisticsService extends Service
{
    public function fansTopTen()
    {
        $rowData = $this->upRawDataDAO->order(array('followers' => 'DESC'))->query(array('uperid', 'name', "followers"), 'uperid');
        return array_slice($rowData,0,10);
    }
    public function getUpDetailsByUpName($upname)
    {
        return $this->upRawDataDAO->filter(array('name' => $upname))->order(array('up_date' => 'DESC'))->find();
    }
}
