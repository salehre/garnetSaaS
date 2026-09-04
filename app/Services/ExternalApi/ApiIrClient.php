<?php

namespace App\Services\ExternalApi;

class ApiIrClient
{
    /**
     * POST to an api.ir endpoint with the shared Bearer token.
     *
     * @return array{success: bool, result: mixed}
     */
    public function post(string $url, array $parameters): array
    {
        $token = config('services.api_ir.token');

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: Bearer {$token}",
            ],
            CURLOPT_POSTFIELDS => json_encode($parameters),
        ]);

        $raw = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            return ['success' => false, 'result' => $error ?: 'connection_failed'];
        }

        $decoded = json_decode($raw);

        if (!$decoded) {
            return ['success' => false, 'result' => 'invalid_json_response'];
        }

        if (empty($decoded->success)) {
            return ['success' => false, 'result' => $decoded->message ?? 'unknown_error'];
        }

        return ['success' => true, 'result' => $decoded->data ?? null];
    }
}