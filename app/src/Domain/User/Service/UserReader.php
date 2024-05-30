<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserReaderResult;
use App\Domain\User\Repository\UserRepository;
use DomainException;

/**
 * Service.
 */
final class UserReader
{
    private UserRepository $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a user.
     *
     * @param int $userId The user id
     *
     * @return UserReaderResult The result
     */
    public function getUser(int $userId): UserReaderResult
    {
        // Input validation
        $this->validateUserRead($userId);

        // Fetch data from the database
        $userRow = $this->repository->getUserById($userId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new UserReaderResult();
        $result->id = $userRow['id'];
        $result->email = $userRow['email'];
        $result->firstname = $userRow['firstname'];
        $result->lastname = $userRow['lastname'];
        //$result->password = $userRow['password'];
        $result->role = $userRow['role'];
        $result->organisation = $userRow['organisation'];
        $result->created_at = $userRow['created_at'];
        $result->updated_at = $userRow['updated_at'];

        return $result;
    }

    public function validateUserRead(int $userId) {
        if (!$this->repository->existsUserId($userId)) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }
    }
}