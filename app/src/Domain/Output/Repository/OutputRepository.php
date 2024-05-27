<?php

namespace App\Domain\Output\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class OutputRepository 
{
    
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function getFinishedJobOutputByUuid(string $outputUuid): array
    {
        $query = $this->queryFactory->newSelect('outputs');
        $query->select(
            [
                'outputs.*',
                'jobs.id as job_id',
                'jobs.uuid as job_uuid',
                'jobs.state as job_state',
                'jobs.size as job_size'            
            ]
        );

        $query->innerJoin('jobs', 'jobs.id = outputs.id_job');
        $query->where(['outputs.uuid' => $outputUuid]);
        $query->where(['jobs.state' => "finished"]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Output not found or not ready: %s', $outputUuid));
        }

        return $row;
    }
}