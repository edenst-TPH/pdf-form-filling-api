<?php

namespace App\Action\Document;

use App\Domain\Document\Data\DocumentFinderResult;
use App\Domain\Document\Service\DocumentFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentFinderAction
{
    private DocumentFinder $documentFinder;

    private JsonRenderer $renderer;

    public function __construct(DocumentFinder $documentFinder, JsonRenderer $jsonRenderer)
    {
        $this->documentFinder = $documentFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $documents = $this->documentFinder->findDocuments();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($documents));
    }

    public function transform(DocumentFinderResult $result): array
    {
        $documents = [];

        foreach ($result->documents as $document) {
            $documents[] = [
                'id' => $document->id,
                'id_folder' => $document->id_folder,
                'title' => $document->title,
                'description' => $document->description,
                'created_at' => $document->created_at,
                'language' => $document->language,
            ];
        }

        return [
            'documents' => $documents,
        ];
    }
}