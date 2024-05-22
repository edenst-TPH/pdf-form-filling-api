<?php
namespace App\Filesystem;
use League\Flysystem\StorageAttributes;

interface DirectoryListerInterface
{
    /**
    * @return StorageAttributes[]
    */
    public function list(string $location): array;
}
