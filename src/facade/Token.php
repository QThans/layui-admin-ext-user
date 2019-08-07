<?php


namespace thans\user\facade;

use think\Facade;

class Token extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\Token';
    }
}
