<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class GeoToAddressHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/GeoToAddress';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'latitude' => (float) $parameters['latitude'],
            'longitude' => (float) $parameters['longitude'],
        ]);
    }
}