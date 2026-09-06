<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class CompanyInfoHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/CompanyInfo';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'nationalID' => ['required', 'string', 'max:11'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'nationalID' => $parameters['nationalID'],
        ]);
    }
}