<?php

namespace App\Services\ExternalApi;

use App\Services\ExternalApi\Contracts\ExternalServiceHandlerInterface;
use App\Services\ExternalApi\Handlers\CardMatchHandler;
use App\Services\ExternalApi\Handlers\CardMobileMatchHandler;
use App\Services\ExternalApi\Handlers\IbanInfoHandler;
use App\Services\ExternalApi\Handlers\IbanMatchHandler;
use App\Services\ExternalApi\Handlers\IsHolidayHandler;
use App\Services\ExternalApi\Handlers\PersonInfoHandler;
use App\Services\ExternalApi\Handlers\ShahkarHandler;
use App\Services\ExternalApi\Handlers\ShahkarLiteHandler;
use App\Services\ExternalApi\Handlers\ShahkarProHandler;

class ExternalServiceRegistry
{
    /**
     * slug (used in the API request + the external_services.slug column) => handler class.
     */
    private const MAP = [
        'shahkar' => ShahkarHandler::class,
        'shahkar-lite' => ShahkarLiteHandler::class,
        'shahkar-pro' => ShahkarProHandler::class,
        'person-info' => PersonInfoHandler::class,
        'card-match' => CardMatchHandler::class,
        'card-mobile-match' => CardMobileMatchHandler::class,
        'iban-match' => IbanMatchHandler::class,
        'is-holiday' => IsHolidayHandler::class,
        'iban-info' => IbanInfoHandler::class,
    ];

    /**
     * slug => Persian display name, shown in the admin "add service" dropdown.
     */
    private const LABELS = [
        'shahkar' => 'احراز هویت شاهکار',
        'shahkar-lite' => 'احراز هویت شاهکار (Lite)',
        'shahkar-pro' => 'احراز هویت شاهکار Pro',
        'person-info' => 'استعلام مشخصات هویتی',
        'card-match' => 'تطبیق کد ملی با کارت بانکی',
        'card-mobile-match' => 'تطبیق کارت بانکی با موبایل',
        'iban-match' => 'تطبیق کد ملی با شبا',
        'is-holiday' => 'استعلام تعطیلی امروز',
        'iban-info' => 'استعلام نام دارنده شبا',
    ];

    /**
     * slug => the exact "نام سرویس" text from the api.ir price sheet, so the
     * Excel importer can auto-assign the right slug to a freshly-imported row.
     */
    private const MATCH_KEYS = [
        'shahkar' => 'احراز هویت شاهکار',
        'shahkar-lite' => 'احراز هویت شاهکار Lite',
        'shahkar-pro' => 'احراز هویت شاهکار Pro',
        'person-info' => 'استعلام مشخصات هویتی',
        'card-match' => 'تطبیق کد ملی با کارت بانکی',
        'card-mobile-match' => 'تطبیق کارت بانکی با موبایل',
        'iban-match' => 'تطبیق کد ملی با شبا',
        'is-holiday' => 'استعلام تعطیلی امروز',
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