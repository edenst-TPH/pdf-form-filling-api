<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CustomerSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name'          => 'Foo',
                'email'         => 'foo@mail.com',
                'organisation'  => 'Foo Organisation',                
                'created'       => date('Y-m-d H:i:s'),
            ],[
                'name'          => 'Bar',
                'email'         => 'bar@mail.com',
                'organisation'  => 'Bar Organisation',  
                'created'       => date('Y-m-d H:i:s'),
                'max_projects'  =>  10
            ]
        ];

        $customers= $this->table('customers');
        $customers->insert($data)->saveData();
    }
}
