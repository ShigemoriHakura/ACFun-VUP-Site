<?php

namespace app\form;
use biny\lib\Form;

class systemUPForm extends Form
{
    protected $_rules = [
        'uperid'=>[self::typeInt],
        'name'=>[self::typeNonEmpty],
    ];

}