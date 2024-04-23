<?php

namespace App\Domain\Document\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class DocumentValidator
{
    public function validateDocument(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('id_folder', true, 'Input required')
            ->notEmptyString('id_folder', 'Input required')
            ->nonNegativeInteger('id_folder', 'Folder id must be a positive integer')

            ->requirePresence('title', true, 'Input required')
            ->notEmptyString('title', 'Input required')
            ->maxLength('title', 64, 'Too long, 64 characters max')
            ->minLength('title', 3, 'Too short, 3 characters min')

            ->requirePresence('language', true, 'Input required')
            ->notEmptyString('language', 'Input required')
            ->maxLength('language', 64, 'Too long, 64 characters max')
            ->minLength('language', 2, 'Too short, 2 characters min')

            ->maxLength('description', 500, 'Too long, 500 characters max');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}