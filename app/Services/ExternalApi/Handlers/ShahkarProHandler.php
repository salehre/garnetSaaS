<?php

namespace App\Services\ExternalApi\Handlers;

use App\Services\ExternalApi\ApiIrClient;
use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;

class ShahkarProHandler implements ExternalServiceHandlerInterface
{
    private const ENDPOINT = 'https://s.api.ir/api/sw1/ShahkarPro';

    public function __construct(private readonly ApiIrClient $client)
    {
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'max:11'],
            'nationalCode' => ['required', 'string', 'max:10'],
            'isCompany' => ['nullable', 'boolean'],
        ];
    }

    public function call(array $parameters): array
    {
        $mobile = $parameters['mobile'];

        if (!str_starts_with($mobile, '0')) {
            $mobile = '0' . $mobile;
        }

        return $this->client->post(self::ENDPOINT, [
            'nationalCode' => $parameters['nationalCode'],
            'mobile' => $mobile,
            'isCompany' => $parameters['isCompany'] ?? false,
        ]);
    }
}