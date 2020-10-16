<?php
/*
 * @Date: 2020-10-16 22:24:52
 * @LastEditors: kanoyami
 * @LastEditTime: 2020-10-17 00:15:50
 */

namespace app\service;

use biny\lib\Service;
use App;

class daliyTopService extends Service
{

    public function getTodayFansupTop()
    {
        $todayTimestamp = strtotime(date('Y-m-d'));
        $upListDataset = $this->upDetailDAO->filter([
            '<' => array('add_date' => $todayTimestamp)
        ])->query();

        $upListDatasets = [];
        $upListDatasetColumn = [];
        $i = 0;

        foreach ($upListDataset as $k => $upData) {
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid' => $upData['uperid'],
                '>=' => array('up_date' => $todayTimestamp)
            ])->order(array('up_date' => 'DESC'))->limit(1)->query();

            $rawOldestData = $this->upRawDataDAO->filter([
                'uperid' => $upData['uperid'],
                '>=' => array('up_date' => $todayTimestamp)
            ])->order(array('up_date' => 'ASC'))->limit(1)->query();
            if ($rawLatestData && $rawOldestData) {
                if ($i >= 10) break;
                $followersAdded = $rawLatestData[0]['followers'] - $rawOldestData[0]['followers'];
                $upListDatasetColumn[$i] = $rawLatestData[0]['followers']; //排序标准
                $upData['rawData'] = $rawLatestData[0];
                $upData['followersAdded'] = $followersAdded;
                $upListDatasets[$i] = $upData;
                $i++;
            }
        }
        array_multisort($upListDatasetColumn, SORT_DESC, $upListDatasets);

        return $upListDatasetColumn;
    }
}
