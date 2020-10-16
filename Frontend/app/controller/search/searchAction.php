<?php

namespace app\controller;
use App;
use biny\lib\Language;
use Constant;

class searchAction extends baseAction
{
    /**
     * 搜索
     */
    public function action_index()
    {
        $keyword = $this->request->get('keyword');
        if($keyword) {
            $uperResult = $this->statisticsService->getUpDetailsByKeyword($keyword);
            return $this->display('search/search', array(
                'uperResult' => $uperResult,
                'keyword' => $keyword,
            ));
        }
        return $this->display('search/index');
    }

    public function action_search($keyword)
    {
        if($keyword) {
            $uperResult = $this->statisticsService->getUpDetailsByKeyword($keyword);
            return $this->display('search/search', array(
                'uperResult' => $uperResult,
                'keyword' => $keyword,
            ));
        }
    }
}