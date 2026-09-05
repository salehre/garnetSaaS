<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class CardMobileMatchHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/CardMobileMatch';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:11'],
            'cardNumber' => ['required', 'string', 'max:16'],
        ];
    }

    public function call(array $parameters): array
    {
        $mobile = $parameters['mobile'];

        if (!str_starts_with($mobile, '0')) {
            $mobile = '0' . $mobile;
        }

        return $this->client->post(self::ENDPOINT, [
            'mobile' => $mobile,
            'cardNumber' => $parameters['cardNumber'],
        ]);
    }
}