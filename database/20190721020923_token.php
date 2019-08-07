<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class Token extends Migrator
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
        $table = $this->table('token', ['id' => false]);
        $table->addColumn('scene', 'string', ['limit' => 15, 'comment' => '场景'])
            ->addColumn('object', 'string', ['limit' => 15, 'comment' => '场景'])
            ->addColumn(
                'token',
                'string',
                ['limit' => 32, 'comment' => 'token值，code请md5验证']
            )
            ->addColumn(
                'create_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0]
            )
            ->addColumn(
                'expired_time',
                'integer',
                [
                    'limit'   => MysqlAdapter::INT_REGULAR,
                    'default' => null,
                    'null'    => true,
                ]
            )
            ->addColumn(
                'verified_time',
                'integer',
                [
                    'limit'   => MysqlAdapter::INT_REGULAR,
                    'default' => null,
                    'null'    => true,
                ]
            )
            ->addIndex(['object', 'token'], ['unique' => false])
            ->create();
    }
}
