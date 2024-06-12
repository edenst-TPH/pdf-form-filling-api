<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['example1'];

        $content = (string)$uploadedFile->getStream();

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $response->getBody()->write(
                json_encode(
                    array(
                        "name" => $uploadedFile->getClientFilename(),
                        "size" => $uploadedFile->getSize(),
                        "ext" => $uploadedFile->getClientMediaType(),
                        "content" => $content,
                        "body" => $request->getParsedBody()
                    )
                )
            );
        }

        return $response->withHeader('Content-Type', 'application/json');



    }

}