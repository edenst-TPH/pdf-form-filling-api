<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;
use App\Support\Helper\DateTimeHelper;
use DomainException;

final class CustomerRepository 
{
    
    // const MAX_PROJECTS_DEFAULT = 5;

    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertCustomer(array $customer): int
    {
        return (int)$this->queryFactory->newInsert('customers', $this->toRow($customer))
            ->execute()
            ->lastInsertId();        
    }

    public function getCustomerById(int $customerId): array
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select(
            [
                'id',
                'email',
                'firstname',
                'lastname',
                'password',
                'organisation',
                'created_at',
                'updated_at'
            ]
        );

        $query->where(['id' => $customerId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }

        return $row;
    }

    public function updateCustomer(int $customerId, array $customer): void
    {
        $customer['updated_at'] =  DateTimeHelper::getDate();
		$row = $this->toRow($customer);

        $this->queryFactory->newUpdate('customers', $row)
            ->where(['id' => $customerId])
            ->execute();
    }

    public function existsCustomerId(int $customerId): bool
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select('id')->where(['id' => $customerId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCustomerById(int $customerId): void
    {
        $this->queryFactory->newDelete('customers')
            ->where(['id' => $customerId])
            ->execute();
    }


    private function toRow(array $customer): array
    {
        return [
            'email' => $customer['email'],
            'firstname' => $customer['firstname'],
            'lastname' => $customer['lastname'],
            'password' => $customer['password'],
            'organisation' => $customer['organisation'],
            'updated_at' => isset($customer['updated_at']) ? $customer['updated_at'] : null
         ];

    }    
}