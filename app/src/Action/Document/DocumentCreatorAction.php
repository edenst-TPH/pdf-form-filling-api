<?php

namespace App\Action\Document;

use App\Domain\Document\Service\DocumentCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentCreatorAction
{
    private JsonRenderer $renderer;

    private DocumentCreator $documentCreator;

    public function __construct(DocumentCreator $documentCreator, JsonRenderer $renderer)
    {
        $this->documentCreator = $documentCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $documentId = $this->documentCreator->createDocument($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['document_id' => $documentId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}