<?php

namespace App\Services\Price\Contracts;

interface PriceProviderInterface
{
    /**
     * Fetch current prices from the provider.
     *
     * @return array{provider: string, data: array<string, mixed>}|false
     */
    public function getPrice(): array|bool;
}
