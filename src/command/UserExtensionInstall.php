<?php

namespace thans\user\command;

use thans\layuiAdmin\model\Menu;
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
        $configFilePath = env('app_path').'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'sms.php';
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
        $configFilePath = env('app_path').'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'mail.php';
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
        $migrationsPath = env('app_path').'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
        copy_dir($this->getPath().'database'.DIRECTORY_SEPARATOR.'migrations',
            $migrationsPath);
        $output->writeln('Copy database migrations end');
        //插入用户管理菜单到后台
        $parent = Menu::where('name', '用户管理')->find();
        if ($parent) {
            if (! Menu::where('uri', 'admin/user')->find()) {
                Menu::create([
                    'name'      => '用户管理',
                    'parent_id' => $parent['id'],
                    'icon'      => '',
                    'uri'       => 'admin/user',
                    'order'     => Menu::count() + 1,
                ]);
                $output->writeln('Menu create success');
            } else {
                $output->writeln('Menu is exist');
            }

        } else {
            $output->writeln('Menu create fail');
        }
    }

    public function createController($output)
    {
        $controllerPath = env('app_path');
        copy_dir($this->getPath().'src'.DIRECTORY_SEPARATOR.'command'.DIRECTORY_SEPARATOR.'stub', $controllerPath);
        $output->writeln('Copy controller end');
    }
}
