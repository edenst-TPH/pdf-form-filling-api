<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class FolderSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'UserSeeder'
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
                'id_user'	=> 2,
                'title'         => 'folder 2.1',
                'description'   => '1st folder of user 2',                
            ],
            [
                'id_user'	=> 2,
                'title'			=> 'folder 2.2',
                'description'	=> '2nd folder of user 2',                
            ],
            [
                'id_user'	=> 3,
                'title'			=> 'folder 3.1',
                'description'	=> '1st folder of user 3',                
            ],
        ];

        $folders= $this->table('folders');
        $folders->insert($data)->saveData();
   }
}
