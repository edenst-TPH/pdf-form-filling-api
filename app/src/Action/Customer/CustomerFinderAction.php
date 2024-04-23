<?php

namespace App\Action\Customer;

use App\Domain\Customer\Data\CustomerFinderResult;
use App\Domain\Customer\Service\CustomerFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerFinderAction
{
    private CustomerFinder $customerFinder;

    private JsonRenderer $renderer;

    public function __construct(CustomerFinder $customerFinder, JsonRenderer $jsonRenderer)
    {
        $this->customerFinder = $customerFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $customers = $this->customerFinder->findCustomers();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($customers));
    }

    public function transform(CustomerFinderResult $result): array
    {
        $customers = [];

        foreach ($result->customers as $customer) {
            $customers[] = [
                'id' => $customer->id,
                'email' => $customer->email,
                'firstname' => $customer->firstname,
                'lastname' => $customer->lastname,
                'password' => $customer->password,
                'organisation' => $customer->organisation,
                'created_at' => $customer->created_at,
                'updated_at' => $customer->updated_at,
            ];
        }

        return [
            'customers' => $customers,
        ];
    }
}