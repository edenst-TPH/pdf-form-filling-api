<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'email'         => 'alice@foo.bar',
                'firstname'     => 'Alice',
                'lastname'      => 'Ecila',
                'password'      =>  password_hash('secret', PASSWORD_DEFAULT),
                'role'          => 'ROLE_ADMIN',
                'organisation'  => 'Alice Organisation',
            ],[
                'email'         => 'bob@foo.bar',
                'firstname'     => 'Bob',
                'lastname'      => 'Obo',
                'password'      =>  password_hash('secret', PASSWORD_DEFAULT),
                'role'          => 'ROLE_INTERNAL',
                'organisation'  => 'Bob Organisation',
            ],[
                'email'         => 'carl@foo.bar',
                'firstname'     => 'Carl',
                'lastname'      => 'Larc',
                'password'      =>  password_hash('secret', PASSWORD_DEFAULT),
                'role'          => 'ROLE_CUSTOMER',
                'organisation'  => 'Carl Organisation',
            ]
        ];

        $users= $this->table('users');
        $users->insert($data)->saveData();
    }
}
