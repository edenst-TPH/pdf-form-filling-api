<?php

namespace App\Domain\Job\Repository;

use App\Factory\QueryFactory;

final class JobFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findJobs(): array
    {
        $query = $this->queryFactory->newSelect('jobs');

        $query->select(
            [
                'id',
                'id_document',
                'size',
                'state',
                'started_at',
                'finished_at',
                'created_at',
            ]
        );

        // Add more "use case specific" conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}