<?php


namespace thans\user\facade;


use think\Facade;

class Mail extends Facade
{
    protected static function getFacadeClass()
    {
        return 'thans\user\provider\Mail';
    }
}
