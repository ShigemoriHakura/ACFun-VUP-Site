<?php

namespace app\dao;

/**
 * 用户表
 */
class upCronDataDAO extends baseDAO
{
    protected $table = 'vup_up_data_cron';
    protected $_pk = 'uperid';
    protected $_pkCache = true;
}