<?php

namespace App\Action\Document;

use App\Domain\Document\Service\DocumentDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentDeleterAction
{
    private DocumentDeleter $documentDeleter;

    private JsonRenderer $renderer;

    public function __construct(DocumentDeleter $documentDeleter, JsonRenderer $renderer)
    {
        $this->documentDeleter = $documentDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $documentId = (int)$args['document_id'];

        // Invoke the domain (service class)
        $this->documentDeleter->deleteDocument($documentId);

        // Render the json response
        return $this->renderer->json($response);
    }
}