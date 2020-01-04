<?php

namespace thans\user\command;

use thans\layuiAdmin\model\Menu;
use think\console\Input;
use think\console\Output;
use think\console\Command;
use think\facade\App;

class UserExtensionInstall extends Command
{
    public function configure()
    {
        $this->setName('layuiAdmin:installUser')
            ->setDescription('install layui-admin user extension');
    }

    public function execute(Input $input, Output $output)
    {
        $this->createController($output);
        $this->createMigrations($output);
    }

    public function getPath()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
    }

    public function createMigrations($output)
    {
        $migrationsPath = App::getRootPath().'database'.DIRECTORY_SEPARATOR.'migrations';
        copy_dir($this->getPath().'database'.DIRECTORY_SEPARATOR.'migrations',
            $migrationsPath);
        $output->writeln('Copy database migrations end');

        $path = App::getRootPath().'.env';
        if (file_exists($path)
            && strpos(file_get_contents($path), 'MAIL')
        ) {
            $output->writeln('Mail config is exists');
        } else {
            $config = <<<EOD
[MAIL]
HOST=smtp.qq.com
ENCRYPTION=ssl
PORT=465
USERNAME=
PASSWORD=
EOD;

            file_put_contents($path, $config, FILE_APPEND);
            $output->writeln('Mail config has created');
        }
    }

    public function createController($output)
    {
        copy_dir($this->getPath().'src'.DIRECTORY_SEPARATOR.'command'.DIRECTORY_SEPARATOR.'stub', App::getAppPath());
        $output->writeln('Copy controller end');
    }
}
