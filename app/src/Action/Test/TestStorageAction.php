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

        //$this->storage->write('test.txt', 'my data');
        
        //  list files
        // $files = $this->storage->list("/");

        // foreach ($files as $file) {
        //     if($file->isFile()){
        //         $output .= $file->path()."\n";
        //     }
        //     # code...
        // }

        //  create directory with timestamp
        //  store text file in newly created directory
        //  read file content/meta information

        $response->getBody()->write(json_decode($output));
        return $response;
    }
}