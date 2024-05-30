<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use DomainException;

final class UserDeleter
{
    private UserRepository $repository;
    private LoggerInterface $logger;

    public function __construct(
        UserRepository $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function deleteUser($userId): void
    {
        $this->validateUserDelete($userId);

        $this->repository->deleteUserById($userId);

        $this->logger->info(sprintf('User deleted successfully: %s', $userId));

    }

    public function validateUserDelete(int $userId): void 
    {
        if(!$this->repository->existsUserId($userId)) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }
    }
}