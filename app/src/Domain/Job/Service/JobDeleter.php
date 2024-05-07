<?php

namespace App\Domain\Job\Service;

use App\Domain\Job\Repository\JobRepository;
use Psr\Log\LoggerInterface;
use DomainException;

final class JobDeleter
{
    private JobRepository $repository;
    private LoggerInterface $logger;

    public function __construct(
        JobRepository $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function deleteJob($jobId): void
    {
        $this->validateJobDelete($jobId);

        $this->repository->deleteJobById($jobId);

        $this->logger->info(sprintf('Job deleted successfully: %s', $jobId));

    }

    public function validateJobDelete(int $jobId): void 
    {
        if(!$this->repository->existsJobId($jobId)) {
            throw new DomainException(sprintf('Job not found: %s', $jobId));
        }
    }
}