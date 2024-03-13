<?php

namespace App\Domain\Customer\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class CustomerValidator
{
    public function validateCustomer(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('name', true, 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 100, 'Too long')

            ->requirePresence('email', true, 'Input required')
            ->email('email', false, 'Invalid email address')

            ->requirePresence('organisation', true, 'Input required')
            ->notEmptyString('organisation', 'Input required')
            ->maxLength('organisation', 100, 'Too long')
            
            ->naturalNumber('max_projects', 'Invalid number');


        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}