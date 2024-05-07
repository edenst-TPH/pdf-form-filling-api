<?php

namespace App\Domain\Job\Repository;

use App\Factory\QueryFactory;
use App\Support\Helper\DateTimeHelper;
use DomainException;

final class JobRepository 
{
    
    const MAX_PROJECTS_DEFAULT = 5;

    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertJob(array $job): int
    {
        return (int)$this->queryFactory->newInsert('jobs', $this->toRow($job), true)
            ->execute()
            ->lastInsertId();        
    }

    public function getJobById(int $jobId): array
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

        $query->where(['id' => $jobId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Job not found: %s', $jobId));
        }

        return $row;
    }

    public function updateJob(int $jobId, array $job): void
    {
        $row = $this->toRow($job);

        $this->queryFactory->newUpdate('jobs', $row)
            ->where(['id' => $jobId])
            ->execute();
    }

    public function existsJobId(int $jobId): bool
    {
        $query = $this->queryFactory->newSelect('jobs');
        $query->select('id')->where(['id' => $jobId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteJobById(int $jobId): void
    {
        $this->queryFactory->newDelete('jobs')
            ->where(['id' => $jobId])
            ->execute();
    }


    private function toRow(array $job): array
    {
			# just filter on our field names
			$aa = [];
			foreach(['id_document', 'size', 'state', 'started_at', 'finished_at'] as $k) { 
				if(isset($job[$k])) { 
					$aa[$k] = $job[$k];
				}
			}
			return $aa;
    }    
}