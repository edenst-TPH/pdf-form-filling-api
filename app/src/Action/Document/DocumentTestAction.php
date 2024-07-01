<?php

namespace App\Action\Document;

use App\Domain\Document\Service\DocumentCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Support\Helper\FileUploadErrorHelper;
use App\Filesystem\Storage;


final class DocumentTestAction
{
    private JsonRenderer $renderer;

    private DocumentCreator $documentCreator;

    private Storage $storage;

    public function __construct(DocumentCreator $documentCreator, JsonRenderer $renderer, Storage $storage)
    {
        $this->documentCreator = $documentCreator;
        $this->renderer = $renderer;
        $this->storage = $storage;
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

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            //$file = $uploadedFile->getStream();

        } else {
            $errorCode = $uploadedFile->getError();
            $errorMessage = FileUploadErrorHelper::getMessage($errorCode);
            $response->getBody()->write(json_encode(array("error" => $errorMessage)));
            return $response->withStatus(400)->withHeader('Content-Type','application/json');
        }

        //$uploadedFile = $uploadedFiles['image'];

        $test = array(
            //"method" => $request->getMethod(),
            //"post" => $_POST,
            //"request" => $request,
            //"headers" => $headers,
            //"attributes" >= $attributes,
            "parsedBody" => $parsedBody,
            "fileName" => $this->moveUploadedFile($uploadedFile)
            //"error" => $uploadedFile->getError()
            //"data" =>  $data
        );


        $response->getBody()->write(json_encode($test));

        return $response->withHeader('Content-Type','application/json');

        // Invoke the Domain with inputs and retain the result
        //$documentId = $this->documentCreator->createDocument($data);

        // Build the HTTP response
        // return $this->renderer
        //     ->json($response, ['document_id' => $data])
        //     ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }

    private function moveUploadedFile($uploadedFile) {


        $extension = "pdf";
        $source = $uploadedFile->getStream()->getMetadata()["uri"];
        //$test = $_FILES["document"]["tmp_name"];

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $destination = "foo" . DIRECTORY_SEPARATOR . $filename;

        $this->storage->write($destination, file_get_contents($source));

        return $destination;
    }
}