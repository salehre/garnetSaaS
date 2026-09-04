<?php

namespace App\Services\ExternalApi\Contracts;

interface ExternalServiceHandlerInterface
{
    /**
     * Laravel validation rules for this service's request parameters.
     */
    public function rules(): array;

    /**
     * Perform the actual api.ir call with already-validated parameters.
     *
     * @return array{success: bool, result: mixed}
     */
    public function call(array $parameters): array;
}