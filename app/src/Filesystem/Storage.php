<?php

namespace App\Filesystem;
use League\Flysystem\FilesystemOperator;

final class Storage implements FileReaderInterface, FileWriterInterface, DirectoryListerInterface, DirectoryCreatorInterface
{
    private FilesystemOperator $filesystem;

    public function __construct(FilesystemOperator $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function read(string $location): string
    {
        return $this->filesystem->read($location);
    }

    public function write(string $location, string $data): void
    {
        $this->filesystem->write($location, $data);
    }

    public function list(string $location): array
    {
        return $this->filesystem->listContents($location)->toArray();
    }

    public function mkdir(string $location): void
    {
        $this->filesystem->createDirectory($location);
    }

}