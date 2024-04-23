<?php

namespace App\Action\Customer;

use App\Domain\Customer\Data\CustomerReaderResult;
use App\Domain\Customer\Service\CustomerReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerReaderAction
{
    private CustomerReader $customerReader;

    private JsonRenderer $renderer;

    public function __construct(CustomerReader $customerReader, JsonRenderer $jsonRenderer)
    {
        $this->customerReader = $customerReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $customerId = (int)$args['customer_id'];

        // Invoke the domain and get the result
        $customer = $this->customerReader->getCustomer($customerId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($customer));
    }

    private function transform(CustomerReaderResult $customer): array
    {
        return [
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
}