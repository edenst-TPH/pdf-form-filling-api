<?php

namespace App\Action\Document;

use App\Domain\Document\Service\DocumentCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DocumentTestAction
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


        //$request = $request->withParsedBody($_POST);

        $headers = $request->getHeaders();

        $data = (array)$request->getParsedBody();

        $attributes = $request->getAttributes();

        $parsedBody = $request->getParsedBody();

        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles["document"];

        //$uploadedFile = $uploadedFiles['image'];

        $test = array(
            //"method" => $request->getMethod(),
            //"post" => $_POST,
            //"request" => $request,
            //"headers" => $headers,
            //"attributes" >= $attributes,
            "parsedBody" => $parsedBody,
            "content" => (string) $uploadedFile->getStream()
            //"error" => $uploadedFile->getError()
            //"data" =>  $data
        );


        $response->getBody()->write(json_encode($test));

        return $response;

        // Invoke the Domain with inputs and retain the result
        //$documentId = $this->documentCreator->createDocument($data);

        // Build the HTTP response
        // return $this->renderer
        //     ->json($response, ['document_id' => $data])
        //     ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}