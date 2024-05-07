<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class JobSeeder extends AbstractSeed
{

    public function getDependencies(): array
    {
        return [
            'DocumentSeeder'
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
                'id_document'	=> 1,
                'size'			=> 11,
                'state'         =>  'initial',                
            ],
            [
                'id_document'	=> 1,
                'size'			=> 22,
                'state'	        => 'running',                
                'started_at'    => date('Y-m-d H:i:s'),                
            ],
            [
                'id_document'	=> 2,
                'size'			=> 33,
                'state'         => 'finished',                
                'started_at'    => date('Y-m-d H:i:s'),                
                'finished_at'   => date('Y-m-d H:i:s'),                
            ],
        ];

        $jobs = $this->table('jobs');
        $jobs->insert($data)->saveData();
   }
}
