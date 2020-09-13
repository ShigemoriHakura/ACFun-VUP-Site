<?php

namespace app\model;
use App;
use biny\lib\ModelArray;

/**
 * Created by PhpStorm.
 * User: billge
 * Date: 15-7-28
 * Time: 下午5:37
 * @property $id int
 * @property $name string
 */
class Admin extends ModelArray
{
    /**
     * @var array 单例对象
     */
    protected static $_instance = [];
    protected $DAO = 'adminDAO';

    /**
     * @param null $id
     * @return person
     */
    public static function init($id=null)
    {
        $id = $id ?: App::$base->session->userId;
        $data = null;
        if (is_array($id)) {
            $data = $id;
            $id = $id['id'];
        }
        if (!isset(self::$_instance[$id])) {
            self::$_instance[$id] = new self($id, $data);
        }
        return self::$_instance[$id];
    }

    /**
     * 登录
     */
    public function login($userid)
    {
        $this->DAO->updateByPk($userid, ['last_login_date'=>time()]);
        App::$base->session->userId = $userid;
    }

    /**
     * 登出
     */
    public function loginOut()
    {
        unset(App::$base->session->userId);
    }
}