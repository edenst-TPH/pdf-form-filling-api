<?php

namespace App\Domain\Job\Service;

use App\Domain\Job\Repository\JobRepository;
use DomainException;
use Psr\Log\LoggerInterface;

final class JobUpdater
{
    private JobRepository $repository;

    private JobValidator $jobValidator;

    private LoggerInterface $logger;

    public function __construct(
        JobRepository $repository,
        JobValidator $jobValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->jobValidator = $jobValidator;
        $this->logger = $logger;
    }

    public function updateJob(int $jobId, array $data): void
    {
        // Input validation
        $this->validateJobUpdate($jobId, $data);

        // Update the row
        $this->repository->updateJob($jobId, $data);

        // Logging
        $this->logger->info(sprintf('Job updated successfully: %s', $jobId));
    }

    public function validateJobUpdate(int $jobId, array $data): void
    {
        if (!$this->repository->existsJobId($jobId)) {
            throw new DomainException(sprintf('Job not found: %s', $jobId));
        }

        $this->jobValidator->validateJob($data);
    }
}