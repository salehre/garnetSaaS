<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class UnpaidChequeProHandler implements ExternalServiceHandlerInterface
{
    // NOTE: the sample curl used the plain /UnpaidCheque path (no "Pro"),
    // even though this is bound to the "استعلام تعداد چک برگشتی پرو" (Pro)
    // row from the price sheet. Confirm if this is intentional.
    private const ENDPOINT = 'https://s.api.ir/api/sw1/UnpaidCheque';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'nationalCode' => ['required', 'string', 'max:10'],
        ];
    }

    public function call(array $parameters): array
    {
        return $this->client->post(self::ENDPOINT, [
            'nationalCode' => $parameters['nationalCode'],
        ]);
    }
}