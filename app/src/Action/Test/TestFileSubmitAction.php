<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
<<<<<<< HEAD
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['example1'];

        $content = (string)$uploadedFile->getStream();
=======
        print_r($_FILES);
        if(
        isset($_FILES['document']) 
        && $_FILES['document']['error'] == UPLOAD_ERR_OK
        && str_ends_with(strtolower($_FILES['document']['name']), '.pdf')
        ) {
            # move_uploaded_file, path see 
            // $body = $request->getParsedBody();
            // print_r($body);
            # https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/issues/39
        }

        $uploadedFiles = $request->getUploadedFiles();
        
        print_r($_FILES); # exists still ..

        $uploadedFile = $uploadedFiles['document'];
>>>>>>> 2544d08 (try foolder_id)

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $response->getBody()->write(
                json_encode(
                    array(
                        "name" => $uploadedFile->getClientFilename(),
                        "size" => $uploadedFile->getSize(),
                        "ext" => $uploadedFile->getClientMediaType(),
<<<<<<< HEAD
                        "content" => $content,
=======
                        // "content" => $uploadedFile->getStream(),
>>>>>>> 2544d08 (try foolder_id)
                        "body" => $request->getParsedBody()
                    )
                )
            );
        }

        return $response->withHeader('Content-Type', 'application/json');

<<<<<<< HEAD


=======
>>>>>>> 2544d08 (try foolder_id)
    }

}