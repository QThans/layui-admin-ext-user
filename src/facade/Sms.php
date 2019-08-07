<?php


namespace thans\user\facade;

use think\Facade;

class Sms extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\Sms';
    }
}
