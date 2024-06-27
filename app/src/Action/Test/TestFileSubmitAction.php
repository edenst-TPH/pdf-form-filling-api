<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    private static function is_positive_integer($s) {
        return (is_numeric($s) && $s > 0 && $s == round($s));
    }

    private static function pdf_uploaded() {
        return (isset($_FILES['document']) 
        && $_FILES['document']['error'] == UPLOAD_ERR_OK
        && str_ends_with(strtolower($_FILES['document']['name']), '.pdf'));
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $err = '';
        # $id_folder
        $body = $request->getParsedBody();
        print_r($body); # debug
        $id_folder = (isset($body['id_folder'])) ? $body['id_folder'] : 0;
        # id_folder must be given, as positive integer (@todo qry parent folder exists)
        if (!$this->is_positive_integer($id_folder) || !$this->pdf_uploaded()){
            $response->getBody()->write(json_encode(
                'error, you must upload a pdf, and provide id_folder as positive integer'
                )
            );
            return $response->withHeader('Content-Type', 'application/json');
        }

        echo 'pp: '.realpath('../storage/documents/'); # debug
        echo 'p: '.realpath('./'); # debug
        $parent = '../storage/documents/'.$id_folder;
        // if(!is_dir($parent)) { mkDir($parent, 0766, true); } # permission probl
        if(!is_dir($parent)) { mkDir($parent); }
        $filename = date('ymdhis').chr(64+rand(0,26)).'.pdf';
        move_uploaded_file($_FILES['document']['tmp_name'], $parent.'/'.$filename);

        # move_uploaded_file, path see 
        # https://github.com/Research-IT-Swiss-TPH/pdf-form-filling-api/issues/39

        # the slim / psr way ..
        $uploadedFiles = $request->getUploadedFiles();
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