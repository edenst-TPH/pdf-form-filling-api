<?php

namespace App\Action\Folder;

use App\Domain\Folder\Data\FolderReaderResult;
use App\Domain\Folder\Service\FolderReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FolderReaderAction
{
    private FolderReader $folderReader;

    private JsonRenderer $renderer;

    public function __construct(FolderReader $folderReader, JsonRenderer $jsonRenderer)
    {
        $this->folderReader = $folderReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $folderId = (int)$args['folder_id'];

        // Invoke the domain and get the result
        $folder = $this->folderReader->getFolder($folderId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($folder));
    }

    private function transform(FolderReaderResult $folder): array
    {
        return [
            'id' => $folder->id,
            'id_customer' => $folder->id_customer,
            'title' => $folder->title,
            'description' => $folder->description,
            'created' => $folder->created
        ];
    }
}