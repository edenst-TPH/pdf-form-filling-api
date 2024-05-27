<?php

namespace App\Domain\Job\Data;

/**
 * DTO.
 */
final class JobFinderItem
{
	public ?int $id = null;
	public ?string $uuid = null;
	public ?int $id_document = null;
	public ?int $size = null;
	public ?string $state = null;
	public ?string $started_at = null;
	public ?string $finished_at = null;
	public ?string $created_at = null;
}