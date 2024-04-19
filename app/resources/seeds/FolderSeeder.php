<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class FolderSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'CustomerSeeder'
        ];
    }

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
                'id_customer'	=> 1,
                'title'         => 'folder 1.1 foo',
                'description'   => '1st folder of customer 1 foo',                
            ],
            [
                'id_customer'	=> 1,
                'title'			=> 'folder 1.2 foo',
                'description'	=> '2nd folder of customer 1 foo',                
            ],
            [
                'id_customer'	=> 2,
                'title'			=> 'folder 2.1 bar',
                'description'	=> '1st folder of customer 2 bar',                
            ],
        ];

        $folders= $this->table('folders');
        $folders->insert($data)->saveData();
   }
}
