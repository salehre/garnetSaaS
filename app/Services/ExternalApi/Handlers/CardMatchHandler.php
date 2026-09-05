<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class CardMatchHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/CardMatch';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            // Customer sends a normal Gregorian date (e.g. "1992-03-21").
            'nationalCode' => ['required', 'string', 'max:10'],
            'birthDate' => ['required', 'date'],
            'cardNumber' => ['required', 'string', 'max:16'],
        ];
    }

    public function call(array $parameters): array
    {
        // api.ir expects the birth date in Jalali (Y/m/d).
        $birthDate = verta($parameters['birthDate'])->format('Y/m/d');

        return $this->client->post(self::ENDPOINT, [
            'nationalCode' => $parameters['nationalCode'],
            'birthDate' => $birthDate,
            'cardNumber' => $parameters['cardNumber'],
        ]);
    }
}