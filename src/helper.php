<?php

use think\App;

if (strpos(App::VERSION, '6.0') === false) {
    require_once 'route'.DIRECTORY_SEPARATOR.'Route.php';
    \think\Console::addDefaultCommands([
        \thans\user\command\UserExtensionInstall::class,
    ]);
}

if (! function_exists('getPath')) {
    function getPath()
    {
        return __DIR__.DIRECTORY_SEPARATOR;
    }
}
