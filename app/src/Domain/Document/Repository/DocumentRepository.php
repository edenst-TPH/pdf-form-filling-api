<?php

namespace App\Domain\Document\Repository;

use App\Factory\QueryFactory;
use App\Support\Helper\DateTimeHelper;
use DomainException;

final class DocumentRepository 
{
    
    const MAX_PROJECTS_DEFAULT = 5;

    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertDocument(array $document): int
    {
        return (int)$this->queryFactory->newInsert('documents', $this->toRow($document), true)
            ->execute()
            ->lastInsertId();        
    }

    public function getDocumentById(int $documentId): array
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
                'updated_at'
            ]
        );

        $query->where(['id' => $documentId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Document not found: %s', $documentId));
        }

        return $row;
    }

    public function updateDocument(int $documentId, array $document): void
    {
        $document['updated_at'] = DateTimeHelper::getDate();
        $row = $this->toRow($document);

        $this->queryFactory->newUpdate('documents', $row)
            ->where(['id' => $documentId])
            ->execute();
    }

    public function existsDocumentId(int $documentId): bool
    {
        $query = $this->queryFactory->newSelect('documents');
        $query->select('id')->where(['id' => $documentId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteDocumentById(int $documentId): void
    {
        $this->queryFactory->newDelete('documents')
            ->where(['id' => $documentId])
            ->execute();
    }


    private function toRow(array $document): array
    {
        return [
            'id_folder' => $document['id_folder'],
            'uuid' => $document['uuid'],
            'title' => $document['title'],
            'description' => $document['description'],
            'updated_at' => isset($document['updated_at']) ? $document['updated_at'] : null
        ];
    }    
}