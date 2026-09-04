<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class IbanInfoHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/IbanInfo';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'iban' => ['required', 'string', 'max:26'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'iban' => $parameters['iban'],
        ]);
    }
}