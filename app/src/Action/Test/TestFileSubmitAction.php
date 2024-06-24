<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        print_r($_FILES); # debug
        if(
        isset($_FILES['document']) 
        && $_FILES['document']['error'] == UPLOAD_ERR_OK
        && str_ends_with(strtolower($_FILES['document']['name']), '.pdf')
        ) {
            # move_uploaded_file, path see 
            $body = $request->getParsedBody();
            print_r($body); # debug
            // $id_folder
            # https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/issues/39
        }

        $uploadedFiles = $request->getUploadedFiles();
        
        print_r($_FILES); # debug, exists still ..

        $uploadedFile = $uploadedFiles['document'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $response->getBody()->write(
                json_encode(
                    array(
                        "name" => $uploadedFile->getClientFilename(),
                        "size" => $uploadedFile->getSize(),
                        "ext" => $uploadedFile->getClientMediaType(),
                        // "content" => $uploadedFile->getStream(), # missing, exception
                        "body" => $request->getParsedBody()
                    )
                )
            );
        }

        return $response->withHeader('Content-Type', 'application/json');

    }

}