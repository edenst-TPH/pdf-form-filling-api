<?php

namespace App\Domain\Folder\Repository;

use App\Factory\QueryFactory;

final class FolderFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFolders(): array
    {
        $query = $this->queryFactory->newSelect('folders');

        $query->select(
            [
                'id',
                'id_customer',
                'title',
                'description',
                'created_at',
                // 'updated_at',
            ]
        );

        // Add more "use case specific" conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}