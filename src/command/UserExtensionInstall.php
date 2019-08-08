<?php

namespace thans\user\command;

use think\console\Input;
use think\console\Output;
use think\console\Command;

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
        $configFilePath = env('app_path').'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'user.php';
        if (is_file($configFilePath)) {
            $output->writeln('Config file is exist');
        } else {
            $res = copy($this->getPath().'config'
                .DIRECTORY_SEPARATOR.'config.php',
                $configFilePath);
            if ($res) {
                $output->writeln('Create config file success:'.$configFilePath);
            } else {
                $output->writeln('Create config file error');
            }
        }
    }

    public function createMigrations($output)
    {
        $migrationsPath = env('app_path').'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
        copy_dir($this->getPath().'database'.DIRECTORY_SEPARATOR.'migrations',
            $migrationsPath);
        $output->writeln('Copy database migrations end');
    }

    public function createController($output)
    {
        $controllerPath = env('app_path');
        copy_dir($this->getPath().'src'.DIRECTORY_SEPARATOR.'command'.DIRECTORY_SEPARATOR.'stub', $controllerPath);
        $output->writeln('Copy controller end');
    }
}
