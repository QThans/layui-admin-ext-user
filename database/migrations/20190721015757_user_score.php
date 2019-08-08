<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class UserScore extends Migrator
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
        $table = $this->table('user_score');
        $table->addColumn('user_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' =>0])
            ->addColumn('change', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'comment' => '变动值'])
            ->addColumn('remark', 'string', ['limit' => 200, 'comment' => '变动说明','default'=>null])
            ->addColumn('obj', 'string', ['limit' => 50, 'comment' => '关联对象','default'=>null])
            ->addColumn('obj_field', 'string', ['limit' => 50, 'comment' => '关联对象字段','default'=>null])
            ->addColumn('obj_value', 'string', ['limit' => 50, 'comment' => '关联对象字段值','default'=>null])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addIndex(['user_id'], ['unique' => false])
            ->create();
    }
}
