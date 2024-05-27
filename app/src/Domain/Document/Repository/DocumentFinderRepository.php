<?php

namespace App\Domain\Document\Repository;

use App\Factory\QueryFactory;

final class DocumentFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findDocuments(): array
    {
        $query = $this->queryFactory->newSelect('documents');

        $query->select(
            [
                'id',
                'uuid',
                'id_folder',
                'title',
                'description',
                'language',
                'created_at',
            ]
        );

        // Add more "use case specific" conditions to the query
        // ...

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}