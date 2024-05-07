<?php

namespace App\Domain\Job\Service;

use App\Domain\Job\Repository\JobRepository;
use App\Domain\Job\Service\JobValidator;
use Psr\Log\LoggerInterface;

final class JobCreator
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

    public function createJob(array $data): int
    {
        // // Input validation
        $this->jobValidator->validateJob($data);

        // Insert job and get new job ID
        $jobId = $this->repository->insertJob($data);

        // // Logging
        $this->logger->info(sprintf('Job created successfully: %s', $jobId));

        return $jobId;
    }

}