<?php

namespace App\Action\Document;

use App\Domain\Document\Data\DocumentReaderResult;
use App\Domain\Document\Service\DocumentReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentReaderAction
{
    private DocumentReader $documentReader;

    private JsonRenderer $renderer;

    public function __construct(DocumentReader $documentReader, JsonRenderer $jsonRenderer)
    {
        $this->documentReader = $documentReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $documentId = (int)$args['document_id'];

        // Invoke the domain and get the result
        $document = $this->documentReader->getDocument($documentId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($document));
    }

    private function transform(DocumentReaderResult $document): array
    {
        return [
            'id' => $document->id,
            'id_folder' => $document->id_folder,
            'title' => $document->title,
            'description' => $document->description,
            'created_at' => $document->created_at,
            'language' => $document->language,
        ];
    }
}