<?php

namespace App\Action\Folder;

use App\Domain\Folder\Service\FolderUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FolderUpdaterAction
{
    private FolderUpdater $folderUpdater;

    private JsonRenderer $renderer;

    public function __construct(FolderUpdater $folderUpdater, JsonRenderer $jsonRenderer)
    {
        $this->folderUpdater = $folderUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $folderId = (int)$args['folder_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->folderUpdater->updateFolder($folderId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}