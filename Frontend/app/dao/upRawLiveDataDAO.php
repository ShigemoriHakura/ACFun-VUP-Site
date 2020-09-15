<?php

namespace app\dao;

/**
 * 用户表
 */
class upRawLiveDataDAO extends baseDAO
{
    protected $table = 'vup_up_live_data';
    protected $_pk = 'id';
    protected $_pkCache = true;
}