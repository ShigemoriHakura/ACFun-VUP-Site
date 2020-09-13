<?php

namespace app\dao;

/**
 * 用户表
 */
class logDAO extends baseDAO
{
    protected $table = 'vup_site_log';
    protected $_pk = 'id';
    protected $_pkCache = true;
}