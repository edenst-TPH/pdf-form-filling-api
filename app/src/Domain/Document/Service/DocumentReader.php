<?php

namespace App\Domain\Document\Service;

use App\Domain\Document\Data\DocumentReaderResult;
use App\Domain\Document\Repository\DocumentRepository;
use DomainException;

/**
 * Service.
 */
final class DocumentReader
{
    private DocumentRepository $repository;

    /**
     * The constructor.
     *
     * @param DocumentRepository $repository The repository
     */
    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a document.
     *
     * @param int $documentId The document id
     *
     * @return DocumentReaderResult The result
     */
    public function getDocument(int $documentId): DocumentReaderResult
    {
        // Input validation
        $this->validateDocumentRead($documentId);

        // Fetch data from the database
        $documentRow = $this->repository->getDocumentById($documentId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new DocumentReaderResult();
        $result->id = $documentRow['id'];
        $result->id_folder = $documentRow['id_folder'];
        $result->title = $documentRow['title'];
        $result->description = $documentRow['description'];
        $result->created_at = $documentRow['created_at'];

        return $result;
    }

    public function validateDocumentRead(int $documentId) {
        if (!$this->repository->existsDocumentId($documentId)) {
            throw new DomainException(sprintf('Document not found: %s', $documentId));
        }
    }
}