<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class ChequeColorHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/ChequeColor';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'nationalCode' => ['required', 'string', 'max:10'],
            'isCompany' => ['nullable', 'boolean'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'nationalCode' => $parameters['nationalCode'],
            'isCompany' => $parameters['isCompany'] ?? false,
        ]);
    }
}