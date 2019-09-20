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
        $this->createConfig($output);
        $this->createController($output);
        $this->createMigrations($output);
    }

    public function getPath()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
    }

    public function createConfig($output)
    {
        $configFilePath = App::getConfigPath().'user.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config file is exist');
        } else {
            $res = copy($this->getPath().'config'
                .DIRECTORY_SEPARATOR.'user.php',
                $configFilePath);
            if ($res) {
                $output->writeln('Create config file success:'.$configFilePath);
            } else {
                $output->writeln('Create config file error');
            }
        }
        $configFilePath = App::getConfigPath().'sms.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config sms file is exist');
        } else {
            $res = copy($this->getPath().'config'
                .DIRECTORY_SEPARATOR.'sms.php',
                $configFilePath);
            if ($res) {
                $output->writeln('Create sms config file success:'.$configFilePath);
            } else {
                $output->writeln('Create sms config file error');
            }
        }
        $configFilePath = App::getConfigPath().'mail.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config mail file is exist');
        } else {
            $res = copy($this->getPath().'config'
                .DIRECTORY_SEPARATOR.'sms.php',
                $configFilePath);
            if ($res) {
                $output->writeln('Create mail config file success:'.$configFilePath);
            } else {
                $output->writeln('Create mail config file error');
            }
        }
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
