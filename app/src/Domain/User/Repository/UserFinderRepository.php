<?php

namespace App\Domain\User\Repository;

use App\Factory\QueryFactory;

final class UserFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findUsers(): array
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

        // Add more "use case specific" conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}