<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use App\Domain\Customer\Service\CustomerValidator;
use App\Support\Validation\ValidationException;

final class CustomerDeleter
{
    private CustomerRepository $repository;
    private CustomerValidator $customerValidator;

    public function __construct(
        CustomerRepository $repository,
        CustomerValidator $customerValidator
    ) {
        $this->repository = $repository;
        $this->customerValidator = $customerValidator;
    }

    public function deleteCustomer($customerId): void
    {
        if(!$this->repository->existsCustomerId($customerId)) {
            throw new ValidationException("Customer with id $customerId does not exist");
        }

        $this->repository->deleteCustomerById($customerId);
    }
}