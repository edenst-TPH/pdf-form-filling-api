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
                'email'         => 'foo@mail.com',
                'firstname'     => 'Fred',
                'lastname'      => 'Foo',
                'password'      => 'password',
                'organisation'  => 'Foo Organisation',                
            ],[
                'email'         => 'bar@mail.com',
                'firstname'     => 'Bill',
                'lastname'      => 'Bar',
                'password'      => 'password',
                'organisation'  => 'Bar Organisation',                
            ]
        ];

        $customers= $this->table('customers');
        $customers->insert($data)->saveData();
    }
}
