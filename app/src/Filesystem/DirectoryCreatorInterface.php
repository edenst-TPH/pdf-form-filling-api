<?php
namespace App\Filesystem;
use League\Flysystem\StorageAttributes;

interface DirectoryCreatorInterface {

    /**
    * @return StorageAttributes[]
    */
    public function mkdir(string $location): void;
}
