<?php

namespace App\Domain\Folder\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class FolderValidator
{
    public function validateFolder(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('id_customer', true, 'Input required')
            ->notEmptyString('id_customer', 'Input required')
            ->maxLength('id_customer', 64, 'Too long')
            ->minLength('id_customer', 64, 'Too short')

            ->requirePresence('title', true, 'Input required')
            ->notEmptyString('title', 'Input required')
            ->maxLength('title', 64, 'Too long')
            ->minLength('title', 3, 'Pls provide a descriptive title')

            ->maxLength('description', 500, 'Too long');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}