<?php


namespace thans\user\facade;

use think\Facade;

class User extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\User';
    }
}
