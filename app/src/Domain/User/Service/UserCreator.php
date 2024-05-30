<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Service\UserValidator;
use Psr\Log\LoggerInterface;

final class UserCreator
{
    private UserRepository $repository;

    private UserValidator $userValidator;

    private LoggerInterface $logger;
    
    public function __construct(
        UserRepository $repository,
        UserValidator $userValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->userValidator = $userValidator;
        $this->logger = $logger;
    }

    public function createUser(array $data): int
    {
        // // Input validation
        $this->userValidator->validateUser($data);

        // Insert user and get new user ID
        $userId = $this->repository->insertUser($data);

        // // Logging
        $this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

}