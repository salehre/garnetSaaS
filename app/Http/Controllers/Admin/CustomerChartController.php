<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyPrice;
use App\Models\CurrencyPriceSnapshot;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerChartController extends Controller
{
    /**
     * period query value => which snapshot interval_type it reads from.
     * "24h" is handled separately since it reads the raw per-minute table.
     */
    private const PERIOD_INTERVAL_MAP = [
        'week' => '2h',
        'month' => '6h',
        '3month' => '12h',
        '6month' => '24h',
    ];

    public function show(Customer $customer): View
    {
        $currencies = $customer->currencies()->orderBy('label')->get();

        return view('admin.customers.chart', compact('customer', 'currencies'));
    }

    public function data(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'currency_id' => ['required', 'integer'],
            'period' => ['required', 'in:24h,week,month,3month,6month'],
        ]);

        // Only ever read a currency this customer is actually assigned —
        // this page shows "what this customer sees", nothing more.
        $currency = $customer->currencies()
            ->where('currencies.id', $validated['currency_id'])
            ->firstOrFail();

        if ($validated['period'] === '24h') {
            $points = CurrencyPrice::where('currency_id', $currency->id)
                ->where('fetched_at', '>=', now()->subHours(24))
                ->orderBy('fetched_at')
                ->get(['price', 'fetched_at'])
                ->map(fn ($row) => [
                    'label' => $row->fetched_at->format('H:i'),
                    'price' => (float) $row->price,
                ]);

            return response()->json([
                'type' => 'raw',
                'points' => $points,
            ]);
        }

        $intervalType = self::PERIOD_INTERVAL_MAP[$validated['period']];

        $buckets = CurrencyPriceSnapshot::where('currency_id', $currency->id)
            ->where('interval_type', $intervalType)
            ->orderBy('snapshotted_at')
            ->get(['bucket_date', 'bucket_range', 'entry_price', 'exit_price', 'min_price', 'max_price', 'avg_price'])
            ->map(fn ($row) => [
                'label' => $row->bucket_date->format('Y-m-d') . ' ' . $row->bucket_range,
                'entry' => (float) $row->entry_price,
                'exit' => (float) $row->exit_price,
                'min' => (float) $row->min_price,
                'max' => (float) $row->max_price,
                'avg' => (float) $row->avg_price,
            ]);

        return response()->json([
            'type' => 'bucket',
            'points' => $buckets,
        ]);
    }
}