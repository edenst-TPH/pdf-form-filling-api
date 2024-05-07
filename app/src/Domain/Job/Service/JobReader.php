<?php

namespace App\Domain\Job\Service;

use App\Domain\Job\Data\JobReaderResult;
use App\Domain\Job\Repository\JobRepository;
use DomainException;

/**
 * Service.
 */
final class JobReader
{
    private JobRepository $repository;

    /**
     * The constructor.
     *
     * @param JobRepository $repository The repository
     */
    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a job.
     *
     * @param int $jobId The job id
     *
     * @return JobReaderResult The result
     */
    public function getJob(int $jobId): JobReaderResult
    {
        // Input validation
        $this->validateJobRead($jobId);

        // Fetch data from the database
        $jobRow = $this->repository->getJobById($jobId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new JobReaderResult();
        $result->id = $jobRow['id'];
        $result->id_document = $jobRow['id_document'];
        $result->size = $jobRow['size'];
        $result->state = $jobRow['state'];
        $result->started_at = $jobRow['started_at'];
        $result->finished_at = $jobRow['finished_at'];
        $result->created_at = $jobRow['created_at'];

        return $result;
    }

    public function validateJobRead(int $jobId) {
        if (!$this->repository->existsJobId($jobId)) {
            throw new DomainException(sprintf('Job not found: %s', $jobId));
        }
    }
}