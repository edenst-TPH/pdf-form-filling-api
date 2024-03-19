<?php

namespace App\Action\Folder;

use App\Domain\Folder\Service\FolderDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FolderDeleterAction
{
    private FolderDeleter $folderDeleter;

    private JsonRenderer $renderer;

    public function __construct(FolderDeleter $folderDeleter, JsonRenderer $renderer)
    {
        $this->folderDeleter = $folderDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $folderId = (int)$args['folder_id'];

        // Invoke the domain (service class)
        $this->folderDeleter->deleteFolder($folderId);

        // Render the json response
        return $this->renderer->json($response);
    }
}