<?php

namespace app\dao;

/**
 * 用户表
 */
class adminDAO extends baseDAO
{
    protected $table = 'vup_site_admin';
    protected $_pk = 'id';
    protected $_pkCache = true;
}