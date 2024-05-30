<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;
use App\Support\Helper\DateTimeHelper;
use DomainException;

final class UserRepository 
{
    
    // const MAX_PROJECTS_DEFAULT = 5;

    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertUser(array $user): int
    {
        //  password has to be hashed then inserted!

        return (int)$this->queryFactory->newInsert('users', $this->toRow($user))
            ->execute()
            ->lastInsertId();
    }

    public function getUserById(int $userId): array
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select(
            [
                'id',
                'email',
                'firstname',
                'lastname',
                //'password',
                'role',
                'organisation',
                'created_at',
                'updated_at'
            ]
        );

        $query->where(['id' => $userId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('User not found: %s', $userId));
        }

        return $row;
    }

    public function updateUser(int $userId, array $user): void
    {
        $user['updated_at'] =  DateTimeHelper::getDate();
		$row = $this->toRow($user);

        $this->queryFactory->newUpdate('users', $row)
            ->where(['id' => $userId])
            ->execute();
    }

    public function existsUserId(int $userId): bool
    {
        $query = $this->queryFactory->newSelect('users');
        $query->select('id')->where(['id' => $userId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteUserById(int $userId): void
    {
        $this->queryFactory->newDelete('users')
            ->where(['id' => $userId])
            ->execute();
    }


    private function toRow(array $user): array
    {
        return [
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'password' => $user['password'],
            'role' => $user['role'],
            'organisation' => $user['organisation'],
            'updated_at' => isset($user['updated_at']) ? $user['updated_at'] : null
         ];

    }    
}