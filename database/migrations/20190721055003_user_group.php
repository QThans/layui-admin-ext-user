<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class UserGroup extends Migrator
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
        $table = $this->table('user_group');
        $table->addColumn('name', 'string', ['limit' => 50, 'default' => null])
            ->addColumn(
                'scene',
                'string',
                ['limit' => 20, 'comment' => '场景', 'default' => 'system']
            )
            ->addColumn(
                'remark',
                'string',
                ['limit' => 200, 'comment' => '备注', 'default' => null]
            )
            ->addColumn(
                'obj',
                'string',
                ['limit' => 50, 'comment' => '关联对象', 'default' => null]
            )
            ->addColumn(
                'condition',
                'string',
                ['limit' => 200, 'comment' => '条件', 'default' => null]
            )
            ->addColumn(
                'create_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0]
            )
            ->addColumn(
                'update_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0]
            )
            ->addColumn(
                'delete_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => null]
            )
            ->addIndex(['scene'], ['unique' => false])
            ->create();
    }
}
