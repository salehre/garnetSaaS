<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class IsHolidayHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/IsHoliday';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            // whether Fridays (weekends) should count as a holiday too.
            'weekend' => ['nullable', 'boolean'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'weekend' => $parameters['weekend'] ?? true,
        ]);
    }
}