<?php

namespace App\Domain\Job\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class JobValidator
{
    public function validateJob(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('id_document', true, 'Input required')
            ->notEmptyString('id_document', 'Input required')
            ->nonNegativeInteger('id_document', 'Document id must be a positive integer')
            ->lessThanOrEqual('size', 10000, 'Too many, 10000 records max')
            ->maxLength('state', 32, 'Too long, 32 characters max');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}