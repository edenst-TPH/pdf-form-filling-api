<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {



        $file = [];
        $uploadedFiles = $request->getUploadedFiles();
        
        if(isset($uploadedFiles['document']) ){
            $uploadedFile =  $uploadedFiles['document'];

            $file = 
            array(
                "name" => $uploadedFile->getClientFilename(),
                "size" => $uploadedFile->getSize(),
                "ext" => $uploadedFile->getClientMediaType(),
            );
        }

        $response->getBody()->write(
            json_encode(
                array(
                    //"files" => $uploadedFiles,
                    "file" => $file,
                    "body" => $request->getParsedBody()
                )
            )
        );

        return $response->withHeader('Content-Type', 'application/json');
    }

}