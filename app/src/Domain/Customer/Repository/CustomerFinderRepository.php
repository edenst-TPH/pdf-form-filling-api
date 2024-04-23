<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;

final class CustomerFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findCustomers(): array
    {
        $query = $this->queryFactory->newSelect('customers');

        $query->select(
            [
                'id',
                'email',
                'firstname',
                'lastname',
                'password',
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