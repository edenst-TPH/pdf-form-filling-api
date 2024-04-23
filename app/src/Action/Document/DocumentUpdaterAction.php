<?php

namespace App\Action\Document;

use App\Domain\Document\Service\DocumentUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentUpdaterAction
{
    private DocumentUpdater $documentUpdater;

    private JsonRenderer $renderer;

    public function __construct(DocumentUpdater $documentUpdater, JsonRenderer $jsonRenderer)
    {
        $this->documentUpdater = $documentUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $documentId = (int)$args['document_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->documentUpdater->updateDocument($documentId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}