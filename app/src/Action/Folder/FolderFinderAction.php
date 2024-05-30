<?php

namespace App\Action\Folder;

use App\Domain\Folder\Data\FolderFinderResult;
use App\Domain\Folder\Service\FolderFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FolderFinderAction
{
    private FolderFinder $folderFinder;

    private JsonRenderer $renderer;

    public function __construct(FolderFinder $folderFinder, JsonRenderer $jsonRenderer)
    {
        $this->folderFinder = $folderFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $folders = $this->folderFinder->findFolders();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($folders));
    }

    public function transform(FolderFinderResult $result): array
    {
        $folders = [];

        foreach ($result->folders as $folder) {
            $folders[] = [
                'id' => $folder->id,
                'id_user' => $folder->id_user,
                'title' => $folder->title,
                'description' => $folder->description,
                'created_at' => $folder->created_at,
                // 'updated_at' => $folder->updated_at,
                ];
        }

        return [
            'folders' => $folders,
        ];
    }
}