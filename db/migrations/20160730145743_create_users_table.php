<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users
            ->addColumn('username', 'string', array('limit' => 20))
            ->addColumn('password', 'string', array('limit' => 100))
            ->addColumn('country', 'string', array('limit' => 50))
            ->addColumn('first_name', 'string', array('limit' => 30))
            ->addColumn('last_name', 'string', array('limit' => 30))
            ->addColumn('zip_code', 'string', array('limit' => 10))
            ->addColumn('created', 'datetime')
            ->addColumn('active', 'boolean', array('default' => true))
            ->addColumn('rating', 'integer', array('null' => true, 'default' => null))
            ->addIndex(array('username'), array('unique' => true))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
