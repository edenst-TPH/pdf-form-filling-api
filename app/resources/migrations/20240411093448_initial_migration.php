<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class InitialMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        //  We need to enable Postgres UUID extension, so that we can call uuid_generate_v4() as default for 'uuid' columns
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $table = $this->table('customers');
        $table
        ->addColumn('email', 'string', ['limit' => 100])
        ->addColumn('firstname', 'string', ['limit' => 100])
        ->addColumn('lastname', 'string', ['limit' => 100])
        ->addColumn('password', 'string', ['limit' => 100])
        ->addColumn('organisation', 'string', ['null' => true, 'limit' => 100])
        // ->addColumn('max_projects', 'integer', ['default' => 5, 'signed' => true])
        ->addTimestamps()
        ->addIndex(['email'], ['unique' => true])
        ->create();

        $table = $this->table('folders');
        $table
        ->addColumn('id_customer', 'integer')
        ->addColumn('title', 'string', ['limit' => 100])
        ->addColumn('description', 'string', ['limit' => 500])
        ->addTimestamps()
        ->addForeignKey('id_customer', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();

        $table = $this->table('documents');
        $table
        ->addColumn('id_folder', 'integer')
        ->addColumn('uuid', 'uuid', ['null' => false, 'default' => Literal::from('uuid_generate_v4()')])
        ->addColumn('title', 'string', ['limit' => 100])
        ->addColumn('description', 'string', ['limit' => 500])
        ->addColumn('language', 'string', ['limit' => 64])
        ->addColumn('field_list', 'json', ['null' => true])
        ->addTimestamps()
        ->addIndex(['uuid'], ['unique' => true])
        ->addForeignKey('id_folder', 'folders', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();

        $table = $this->table('jobs');
        $table
        ->addColumn('id_document', 'integer')
        ->addColumn('uuid', 'uuid', ['null' => false, 'default' => Literal::from('uuid_generate_v4()')])
        ->addColumn('size', 'integer')
        ->addColumn('state', 'string', ['limit' => 32])
        ->addColumn('started_at', 'timestamp')
        ->addColumn('finished_at', 'timestamp')
        ->addTimestamps(null, false) # created_at only
        ->addIndex(['uuid'], ['unique' => true])
        ->addForeignKey('id_document', 'documents', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();

        $table = $this->table('outputs');
        $table
        ->addColumn('id_job', 'integer')
        ->addColumn('uuid', 'uuid', ['null' => false, 'default' => Literal::from('uuid_generate_v4()')])
        ->addColumn('deleted_at', 'timestamp')
        ->addTimestamps(null, false) # created_at only
        ->addIndex(['uuid'], ['unique' => true])
        ->addForeignKey('id_job', 'jobs', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();
    }
}
