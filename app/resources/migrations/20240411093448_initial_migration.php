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

        $users = $this->table('users');
        $users
        ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
        ->addColumn('firstname', 'string', ['limit' => 255])
        ->addColumn('lastname', 'string', ['limit' => 255])
        ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
        ->addColumn('role', 'string', ['limit' => 255, 'null' => false, 'default' => 'ROLE_CUSTOMER'])
        ->addColumn('organisation', 'string', ['limit' => 255])
        ->addTimestamps()
        ->addIndex(['email'], ['unique' => true])
        ->create();

        $folders = $this->table('folders');
        $folders
        ->addColumn('id_user', 'integer')
        ->addColumn('title', 'string', ['limit' => 100])
        ->addColumn('description', 'string', ['limit' => 500])
        ->addTimestamps()
        ->addForeignKey('id_user', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();

        $documents = $this->table('documents');
        $documents
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

        $jobs = $this->table('jobs');
        $jobs
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

        $outputs = $this->table('outputs');
        $outputs
        ->addColumn('id_job', 'integer')
        ->addColumn('uuid', 'uuid', ['null' => false, 'default' => Literal::from('uuid_generate_v4()')])
        ->addColumn('deleted_at', 'timestamp')
        ->addTimestamps(null, false) # created_at only
        ->addIndex(['uuid'], ['unique' => true])
        ->addForeignKey('id_job', 'jobs', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
        ->create();
    }
}
