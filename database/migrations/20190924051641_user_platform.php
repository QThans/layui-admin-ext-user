<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class UserPlatform extends Migrator
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
        $table = $this->table('user_platform');
        $table->addColumn('user_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => null])
            ->addColumn('platform_id', 'string', ['limit' => 60, 'comment' => '平台id'])
            ->addColumn('platform_token', 'string', ['limit' => 60, 'comment' => '平台access_token', 'default' => null])
            ->addColumn('type', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '平台类型 0:未知,1:facebook,2:google,3:wechat,4:qq,5:weibo,6:twitter', 'default' => null])
            ->addColumn('nickname', 'string', ['limit' => 50, 'comment' => '昵称', 'default' => null])
            ->addColumn('avatar', 'string', ['limit' => 255, 'comment' => '头像', 'default' => null])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addIndex(['user_id', 'platform_id'], ['unique' => false])
            ->create();
    }
}
