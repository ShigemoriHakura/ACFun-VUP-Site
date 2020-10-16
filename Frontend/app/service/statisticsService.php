<?php

namespace app\service;

use biny\lib\Service;
use App;

class statisticsService extends Service
{
    public function getFollowersListDesc($limit)
    {
        $rowData = $this->upRawDataDAO->order(array('followers' => 'DESC'))->query(array('uperid', 'name', "followers"), 'uperid');
        return array_slice($rowData, 0, $limit);
    }

    public function getUpDetailsByKeyword($keyword){
        $keyword = urldecode($keyword);
        $uperResult = $this->upDetailDAO->merge(array(
            '__like__'=>array(
                'name'=>array($keyword),
                'uperid'=>array($keyword),
                'nowName'=>array($keyword),
            )
        ))->query();
        return $uperResult;
    }

    public function getMedalsByKeyword($keyword){
        $keyword = urldecode($keyword);
        $medalResult = $this->upMedalDAO->merge(array(
            '__like__'=>array(
                'clubName'=>array($keyword),
                'uperid'=>array($keyword),
            )
        ))->query();
        if(count($medalResult) > 0){
            $upIDName = [];
            $upDataset = $this->upDetailDAO->query();
            foreach ($upDataset as $up){
                $upIDName[$up['uperid']] = array(
                    "name" => $up['name'],
                    "nowName" => $up['nowName']
                );
            }
            foreach ($medalResult as $k => $medal){
                $medal["up"] = $upIDName[$medal["uperid"]];
                $medalResult[$k] = $medal;
            }
        }
        return $medalResult;
    }
}
