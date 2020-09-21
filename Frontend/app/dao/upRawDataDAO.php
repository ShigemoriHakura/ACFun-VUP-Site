<?php

namespace app\dao;

/**
 * 用户表
 */
class upRawDataDAO extends baseDAO
{
    protected $table = 'vup_up_data';
    protected $_pk = 'uperid';
    protected $_pkCache = true;
}