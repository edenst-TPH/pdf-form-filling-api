<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use DomainException;
use Psr\Log\LoggerInterface;

final class UserUpdater
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

    public function updateUser(int $userId, array $data): void
    {
        // Input validation
        $this->validateUserUpdate($userId, $data);

        // Update the row
        $this->repository->updateUser($userId, $data);

        // Logging
        $this->logger->info(sprintf('User updated successfully: %s', $userId));
    }

    public function validateUserUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsUserId($userId)) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }

        $this->userValidator->validateUser($data);
    }
}