<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Filesystem\Storage;

final class TestStorageAction {

    private Storage $storage;

    public function __construct(Storage $storage) 
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $output = "";

        $username = "foo_bar";
        $id = time();
        $path = $username . "_" . $id;

        //  create directory with timestamp
        $this->storage->mkdir( $path );

        //  write file inside directory
        $this->storage->write($path . '/the_pdf_file.txt', 'This file has been created at ' . date('l jS \of F Y h:i:s A'));
        
        // //  list files (not needed)
        // $files = $this->storage->list("/");

        // foreach ($files as $file) {
        //     if($file->isFile()){
        //         $output .= $file->path(). '<br>';
        //     }
        //     # code...
        // }

        //  read file content/meta information

        $response->getBody()->write(json_encode($output));
        return $response;
    }
}