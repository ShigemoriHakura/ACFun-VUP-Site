<?php

namespace app\form;
use biny\lib\Form;

class systemLogForm extends Form
{
    protected $_rules = [
        'level'=>[self::typeInt],
        'content'=>[self::typeNonEmpty],
    ];

}