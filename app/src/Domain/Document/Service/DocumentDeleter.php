<?php

namespace App\Domain\Document\Service;

use App\Domain\Document\Repository\DocumentRepository;
use Psr\Log\LoggerInterface;
use DomainException;

final class DocumentDeleter
{
    private DocumentRepository $repository;
    private LoggerInterface $logger;

    public function __construct(
        DocumentRepository $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function deleteDocument($documentId): void
    {
        $this->validateDocumentDelete($documentId);

        $this->repository->deleteDocumentById($documentId);

        $this->logger->info(sprintf('Document deleted successfully: %s', $documentId));

    }

    public function validateDocumentDelete(int $documentId): void 
    {
        if(!$this->repository->existsDocumentId($documentId)) {
            throw new DomainException(sprintf('Document not found: %s', $documentId));
        }
    }
}