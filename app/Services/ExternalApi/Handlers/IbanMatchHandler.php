<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class IbanMatchHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/IbanMatch';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            // Customer sends a normal Gregorian date (e.g. "2024-03-15").
            'birthDate' => ['required', 'date'],
            'iban' => ['required', 'string', 'max:26'],
            'nationalCode' => ['required', 'string', 'max:10'],
        ];
    }

    public function call(array $parameters): array
    {
        // api.ir expects the birth date in Jalali (Y/m/d) — convert from the
        // Gregorian date the customer sent us. Requires hekmatinasser/verta.
        $birthDate = verta($parameters['birthDate'])->format('Y/m/d');

        return $this->client->post(self::ENDPOINT, [
            'nationalCode' => $parameters['nationalCode'],
            'birthDate' => $birthDate,
            'iban' => $parameters['iban'],
        ]);
    }
}