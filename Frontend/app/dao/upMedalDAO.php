<?php

namespace app\dao;

/**
 * 用户表
 */
class upMedalDAO extends baseDAO
{
    protected $table = 'vup_up_medal';
    protected $_pk = 'uperid';
    protected $_pkCache = true;
}