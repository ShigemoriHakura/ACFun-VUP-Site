<?php

namespace app\dao;

/**
 * 用户表
 */
class upLiveDataCronDAO extends baseDAO
{
    protected $table = 'vup_up_live_data_cron';
    protected $_pk = 'uperid';
    protected $_pkCache = true;
}