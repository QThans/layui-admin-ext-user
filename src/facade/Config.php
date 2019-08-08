<?php


namespace thans\user\facade;

use think\Facade;

class Config extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\Config';
    }
}
