<?php

namespace app\form;
use biny\lib\Form;

class loginForm extends Form
{
    protected $_rules = [
        'username'=>[self::typeNonEmpty],
        'password'=>[self::typeNonEmpty],
    ];

}