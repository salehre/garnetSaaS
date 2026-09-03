<?php

namespace App\Services\Price\Providers;

use App\Services\Price\Contracts\PriceProviderInterface;

class TabanGoharProvider implements PriceProviderInterface
{
    private const ENDPOINT = 'https://webservice.tgnsrv.ir/Pr/Get';

    public function __construct(
        private string $username = '',
        private string $password = '',
    ) {
        $this->username = $username ?: (string) config('services.tabangohar.username');
        $this->password = $password ?: (string) config('services.tabangohar.password');
    }

    public function getPrice(): array|bool
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => self::ENDPOINT . '/' . $this->username . '/' . $this->password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'User-Agent: GarnetCore/1.0',
            ],
        ]);

        $response = curl_exec($curl);
        $errno = curl_errno($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($errno !== 0 || $response === false || $status !== 200) {
            return false;
        }

        $data = json_decode($response, true);

        if (!is_array($data)) {
            return false;
        }

        // NOTE: values are returned in Toman, as-is. No unit conversion here —
        // conversion to Rial (if a customer wants it) happens at API-response time,
        // based on that customer's `price_unit` setting. See Customer::convertPrice().
        return [
            'provider' => 'TabanGohar',
            'data' => $data,
        ];
    }
}
