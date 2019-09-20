<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\facade\App;
use think\migration\Migrator;
use think\migration\db\Column;

class UserMenu extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('menu');

        $default = App::getInstance()->config->get('database.default');

        $config = App::getInstance()->config->get("database.connections.{$default}");

        $row = $this->fetchRow("SELECT * FROM `".$config['prefix']."menu` WHERE `name` = '用户管理' LIMIT 1;");

        if (! $this->fetchRow("SELECT * FROM `".$config['prefix']."menu` WHERE `uri` = 'admin/user' LIMIT 1;")) {
            $data[] = [
                'name'        => '用户管理',
                'parent_id'   => $row['id'],
                'icon'        => '',
                'order'       => 1000,
                'uri'         => 'admin/user',
                'create_time' => time(),
                'update_time' => time(),
            ];
            $table->insert($data);
            $table->saveData();
        }
    }
}
