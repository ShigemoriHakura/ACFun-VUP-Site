<?php

namespace app\dao;

/**
 * 用户表
 */
class upDetailDAO extends baseDAO
{
    protected $table = 'vup_up_list';
    protected $_pk = 'id';
    protected $_pkCache = true;
}