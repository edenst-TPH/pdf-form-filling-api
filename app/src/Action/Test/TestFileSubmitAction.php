<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestFileSubmitAction {

    private static function is_positive_integer($s) {
        return (is_numeric($s) && $s > 0 && $s == round($s));
    }

    private static function randchars($count) {
        $s = '';
        for($i = 1; $i <= $count; $i++) { $s .= chr(64+rand(0,26)); }
        return $s;
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
        # debug
        $aa = [
            '__DIR__' => __DIR__,
            'r-current' => realpath('./'),
            'r-docs' => realpath('./pff-docs'),
            'current' => './',
            'docs' => './pff-docs',
        ];
        print_r($aa);

        $docs_dir = realpath('./pff-docs'); # must exist an be writeable @todo get from scontainer
        if(!is_dir($docs_dir)) { echo 'docs parent missing!: '.$docs_dir; }
        $doc_dir = $docs_dir.'/'.$id_folder; # current doc int subdir id_folder
        echo ' | doc_dir: '. $doc_dir;

        // if(!is_dir($parent)) { mkDir($parent, 0766, true); } # permission problem
        if(!is_dir($doc_dir)) { mkDir($doc_dir, 0766); }
        $filename = date('ymdhis').'-'.$this->randChars(2).'.pdf';
        move_uploaded_file($_FILES['document']['tmp_name'], $doc_dir.'/'.$filename);

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