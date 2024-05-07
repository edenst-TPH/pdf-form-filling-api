<?php

namespace App\Domain\Job\Service;

use App\Domain\Job\Data\JobFinderItem;
use App\Domain\Job\Data\JobFinderResult;
use App\Domain\Job\Repository\JobFinderRepository;

final class JobFinder
{
    private JobFinderRepository $repository;

    public function __construct(JobFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findJobs(): JobFinderResult
    {
        // Input validation
        // ...

        $jobs = $this->repository->findJobs();

        return $this->createResult($jobs);
    }

    private function createResult(array $jobRows): JobFinderResult
    {
        $result = new JobFinderResult();

        foreach ($jobRows as $jobRow) {
            $job = new JobFinderItem();
            $job->id = $jobRow['id'];
            $job->id_document = $jobRow['id_document'];
            $job->size = $jobRow['size'];
            $job->state = $jobRow['state'];
            $job->started_at = $jobRow['started_at'];
            $job->finished_at = $jobRow['finished_at'];
            $job->created_at = $jobRow['created_at'];
            
            $result->jobs[] = $job;
        }

        return $result;
    }
}