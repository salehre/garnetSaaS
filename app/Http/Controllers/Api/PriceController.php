<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * GET /api/prices
     *
     * Returns the latest price of every currency this authenticated customer
     * is allowed to see, converted to that customer's preferred unit
     * (toman or rial — see Customer::convertPrice()).
     */
    public function index(Request $request): JsonResponse
    {
        $customer = $request->attributes->get('customer');

        $currencies = $customer->currencies()
            ->where('currencies.is_active', true)
            ->with('latestPrice')
            ->get();

        $data = $currencies->map(function ($currency) use ($customer) {
            $latest = $currency->latestPrice;

            return [
                'code' => $currency->code,
                'label' => $currency->label,
                'price' => $latest ? $customer->convertPrice((float) $latest->price) : null,
                'updated_at' => $latest?->fetched_at?->toIso8601String(),
            ];
        });

        return response()->json([
            'unit' => $customer->price_unit,
            'data' => $data,
        ]);
    }
}
