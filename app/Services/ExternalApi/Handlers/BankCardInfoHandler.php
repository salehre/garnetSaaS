<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class BankCardInfoHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/BankCardInfo';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'cardNumber' => ['required', 'string', 'max:16'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'cardNumber' => $parameters['cardNumber'],
        ]);
    }
}