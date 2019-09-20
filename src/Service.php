<?php

namespace thans\user;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands(\thans\user\command\UserExtensionInstall::class);
        $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'route'.DIRECTORY_SEPARATOR.'Route.php');
    }
}
