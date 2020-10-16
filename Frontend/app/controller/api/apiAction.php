<?php
/*
 * @Date: 2020-10-16 20:17:52
 * @LastEditors: kanoyami
 * @LastEditTime: 2020-10-17 00:03:45
 */

namespace app\controller;

function jsonFormat($errcode, $something)
{
    return array(
        "result" => $errcode,
        "data" => $something
    );
}

class apiAction extends baseAction
{
    /**
     * API
     */
    public function action_index()
    {
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        return json_encode($result);
    }

    public function action_up_detail($upid)
    {
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        if ($upid) {
            $date = $this->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) + 86400;
            if ($date) {
                $todayTimestamp = strtotime(date('Y-m-d', $date)) + 86400;
            }
            $rawLatestData = $this->upRawDataDAO->filter([
                'uperid' => $upid,
                '<=' => array('up_date' => $todayTimestamp)
            ])->order(array('up_date' => 'DESC'))->limit(1)->query();
            $result["data"] = $rawLatestData;
        } else {
            $result["data"] = "no uperid";
        }
        return json_encode($result);
    }

    public function action_up_cron($upid)
    {
        $result = array(
            "result" => 1,
            "data" => "Hello world"
        );
        if ($upid) {
            $date = $this->get('day');
            $todayTimestamp = strtotime(date('Y-m-d')) - 1;
            if ($date) {
                $todayTimestamp = strtotime(date('Y-m-d', $date));
            }
            $cronLatestData = $this->upCronDataDAO->filter([
                'uperid' => $upid,
                '<=' => array('add_date' => $todayTimestamp)
            ])->order(array('add_date' => 'DESC'))->limit(1)->query();
            $result["data"] = $cronLatestData;
        } else {
            $result["data"] = "no uperid";
        }
        return json_encode($result);
    }

    public function action_up_fansup_topten_daliy()
    {
        $this->response->json(jsonFormat(1, $this->daliyTopService->getTodayFansupTop()));
    }

    public function action_up_fans_topten()
    {
        $this->response->json(jsonFormat(1, $this->statisticsService->fansTopTen()));
    }

    public function action_up_detail_by_name($upname)
    {
        $this->response->json(jsonFormat(1, $this->statisticsService->getUpDetailsByUpName($upname)));
    }
}
