<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Data\CustomerReaderResult;
use App\Domain\Customer\Repository\CustomerRepository;
use DomainException;

/**
 * Service.
 */
final class CustomerReader
{
    private CustomerRepository $repository;

    /**
     * The constructor.
     *
     * @param CustomerRepository $repository The repository
     */
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a customer.
     *
     * @param int $customerId The customer id
     *
     * @return CustomerReaderResult The result
     */
    public function getCustomer(int $customerId): CustomerReaderResult
    {
        // Input validation
        $this->validateCustomerRead($customerId);

        // Fetch data from the database
        $customerRow = $this->repository->getCustomerById($customerId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new CustomerReaderResult();
        $result->id = $customerRow['id'];
        $result->email = $customerRow['email'];
        $result->firstname = $customerRow['firstname'];
        $result->lastname = $customerRow['lastname'];
        $result->password = $customerRow['password'];
        $result->organisation = $customerRow['organisation'];
        $result->created_at = $customerRow['created_at'];
        $result->updated_at = $customerRow['updated_at'];

        return $result;
    }

    public function validateCustomerRead(int $customerId) {
        if (!$this->repository->existsCustomerId($customerId)) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }
    }
}