<?php

namespace App\Domain\Document\Service;

use App\Domain\Document\Repository\DocumentRepository;
use DomainException;
use Psr\Log\LoggerInterface;

final class DocumentUpdater
{
    private DocumentRepository $repository;

    private DocumentValidator $documentValidator;

    private LoggerInterface $logger;

    public function __construct(
        DocumentRepository $repository,
        DocumentValidator $documentValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->documentValidator = $documentValidator;
        $this->logger = $logger;
    }

    public function updateDocument(int $documentId, array $data): void
    {
        // Input validation
        $this->validateDocumentUpdate($documentId, $data);

        // Update the row
        $this->repository->updateDocument($documentId, $data);

        // Logging
        $this->logger->info(sprintf('Document updated successfully: %s', $documentId));
    }

    public function validateDocumentUpdate(int $documentId, array $data): void
    {
        if (!$this->repository->existsDocumentId($documentId)) {
            throw new DomainException(sprintf('Document not found: %s', $documentId));
        }

        $this->documentValidator->validateDocument($data);
    }
}