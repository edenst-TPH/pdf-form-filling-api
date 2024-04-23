<?php

namespace App\Domain\Document\Service;

use App\Domain\Document\Data\DocumentFinderItem;
use App\Domain\Document\Data\DocumentFinderResult;
use App\Domain\Document\Repository\DocumentFinderRepository;

final class DocumentFinder
{
    private DocumentFinderRepository $repository;

    public function __construct(DocumentFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findDocuments(): DocumentFinderResult
    {
        // Input validation
        // ...

        $documents = $this->repository->findDocuments();

        return $this->createResult($documents);
    }

    private function createResult(array $documentRows): DocumentFinderResult
    {
        $result = new DocumentFinderResult();

        foreach ($documentRows as $documentRow) {
            $document = new DocumentFinderItem();
            $document->id = $documentRow['id'];
            $document->id_folder = $documentRow['id_folder'];
            $document->title = $documentRow['title'];
            $document->description = $documentRow['description'];
            $document->created_at = $documentRow['created_at'];
            
            $result->documents[] = $document;
        }

        return $result;
    }
}