<?php

namespace App\Domain\Document\Data;

/**
 * DTO.
 */
final class DocumentReaderResult
{
    public ?int $id = null;
    public ?int $id_folder = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $language = null;
    public ?string $created_at = null;
}