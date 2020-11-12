<?php

namespace app\dao;

/**
 * 用户表
 */
class upGiftDataDAO extends baseDAO
{
    protected $table = 'vup_danmaku_gift_data';
    protected $_pk = 'uperid';
    protected $_pkCache = false;
}