<?php


namespace thans\user\facade;

use think\Facade;

class Auth extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\Auth';
    }
}
