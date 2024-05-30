<?php

namespace App\Domain\User\Service;

use App\Domain\User\Data\UserFinderItem;
use App\Domain\User\Data\UserFinderResult;
use App\Domain\User\Repository\UserFinderRepository;

final class UserFinder
{
    private UserFinderRepository $repository;

    public function __construct(UserFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findUsers(): UserFinderResult
    {
        // Input validation
        // ...

        $users = $this->repository->findUsers();

        return $this->createResult($users);
    }

    private function createResult(array $userRows): UserFinderResult
    {
        $result = new UserFinderResult();

        foreach ($userRows as $userRow) {
            $user = new UserFinderItem();
            $user->id = $userRow['id'];
            $user->email = $userRow['email'];
            $user->firstname = $userRow['firstname'];
            $user->lastname = $userRow['lastname'];
            //$user->password = $userRow['password'];
            $user->role = $userRow['role'];
            $user->organisation = $userRow['organisation'];
            $user->created_at = $userRow['created_at'];
            $user->updated_at = $userRow['updated_at'];
            
            $result->users[] = $user;
        }

        return $result;
    }
}