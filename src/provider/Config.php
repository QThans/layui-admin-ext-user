<?php


namespace thans\user\provider;

class Config
{
    public function sms()
    {
        $config = require __DIR__.'/../../config/sms.php';

        return array_merge($config, \think\facade\Config::get('sms') ?? []);
    }

    public function user()
    {
        $config = require __DIR__.'/../../config/user.php';
        return array_merge($config, \think\facade\Config::get('user') ?? []);
    }

    public function mail()
    {
        $config = require __DIR__.'/../../config/mail.php';

        return array_merge($config, \think\facade\Config::get('mail') ?? []);
    }
}
