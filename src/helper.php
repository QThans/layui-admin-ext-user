<?php
require_once 'route'.DIRECTORY_SEPARATOR.'Route.php';


\think\Console::addDefaultCommands([
    \thans\user\command\UserExtensionInstall::class,
]);


function getPath()
{
    return __DIR__.DIRECTORY_SEPARATOR;
}
