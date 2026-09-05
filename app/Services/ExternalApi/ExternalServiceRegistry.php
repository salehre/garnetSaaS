<?php

namespace App\Services\ExternalApi;

use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;
use App\Services\ExternalApi\Handlers\IbanInfoHandler;
use App\Services\ExternalApi\Handlers\IbanMatchHandler;
use App\Services\ExternalApi\Handlers\ShahkarLiteHandler;

class ExternalServiceRegistry
{
    /**
     * slug (used in the API request + the external_services.slug column) => handler class.
     */
    private const MAP = [
        'shahkar-lite' => ShahkarLiteHandler::class,
        'iban-match' => IbanMatchHandler::class,
        'iban-info' => IbanInfoHandler::class,
    ];

    /**
     * slug => Persian display name, shown in the admin "add service" dropdown.
     */
    private const LABELS = [
        'shahkar-lite' => 'احراز هویت شاهکار (Lite)',
        'iban-match' => 'تطبیق کد ملی با شبا',
        'iban-info' => 'استعلام نام دارنده شبا',
    ];

    /**
     * slug => the exact "نام سرویس" text from the api.ir price sheet, so the
     * Excel importer can auto-assign the right slug to a freshly-imported row.
     */
    private const MATCH_KEYS = [
        'shahkar-lite' => 'احراز هویت شاهکار Lite',
        'iban-match' => 'تطبیق کد ملی با شبا',
        'iban-info' => 'استعلام نام دارنده شبا',
    ];

    public static function has(string $slug): bool
    {
        return array_key_exists($slug, self::MAP);
    }

    public static function resolve(string $slug): ?ExternalServiceHandlerInterface
    {
        $class = self::MAP[$slug] ?? null;

        return $class ? app($class) : null;
    }

    public static function labelFor(string $slug): string
    {
        return self::LABELS[$slug] ?? $slug;
    }

    /**
     * Given the exact "نام سرویس" text from the Excel sheet, return the slug
     * we've already written a handler for — or null if it's not one of ours yet.
     */
    public static function slugForMatchKey(string $matchKey): ?string
    {
        $slug = array_search($matchKey, self::MATCH_KEYS, true);

        return $slug !== false ? $slug : null;
    }

    /**
     * All known slug => label pairs, for populating the admin dropdown.
     */
    public static function all(): array
    {
        return self::LABELS;
    }
}
