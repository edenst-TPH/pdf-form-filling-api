<?php

namespace App\Domain\User\Data;

/**
 * DTO.
 */
final class UserReaderResult
{
    public ?int $id = null;
    public ?string $email = null;
    public ?string $firstname = null;
    public ?string $lastname = null;
    //public ?string $password = null;
    public ?string $role = null;
    public ?string $organisation = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
}