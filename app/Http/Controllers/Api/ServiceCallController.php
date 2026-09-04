<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExternalService;
use App\Services\ExternalApi\ExternalServiceRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ServiceCallController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $customer = $request->attributes->get('customer');

        $slug = $request->input('service');

        if (!$slug || !ExternalServiceRegistry::has($slug)) {
            return response()->json(['message' => 'Unknown or unsupported service.'], 422);
        }

        $service = ExternalService::where('slug', $slug)->where('is_active', true)->first();

        if (!$service) {
            return response()->json(['message' => 'This service is not currently available.'], 404);
        }

        if (!$customer->hasService($slug)) {
            return response()->json(['message' => 'This service is not enabled for your account.'], 403);
        }

        // Cheap pre-check before we even touch the cache/upstream call — no
        // point calling api.ir for a customer who can't pay for it anyway.
        if ($customer->balance < $service->price) {
            return response()->json(['message' => 'Insufficient balance.'], 402);
        }

        $handler = ExternalServiceRegistry::resolve($slug);

        $validated = Validator::make($request->all(), $handler->rules())->validate();

        // Stable, order-independent cache key per service + input combination.
        ksort($validated);
        $cacheKey = 'ext_service:' . $slug . ':' . md5(json_encode($validated));

        $result = Cache::remember($cacheKey, now()->addDay(), fn () => $handler->call($validated));

        if (!$result['success']) {
            return response()->json([
                'message' => 'Upstream service failed.',
                'detail' => $result['result'],
            ], 502);
        }

        // Billed on every successful call, cache hit or not — caching only
        // saves us a redundant call to api.ir, it doesn't make the lookup free.
        $charged = $customer->chargeForService($service, "external-service:{$slug}");

        if (!$charged) {
            // Balance could have changed between the pre-check above and now
            // (e.g. a concurrent request) — chargeForService re-checks atomically.
            return response()->json(['message' => 'Insufficient balance.'], 402);
        }

        return response()->json([
            'service' => $slug,
            'result' => $result['result'],
            'balance' => (float) $customer->balance,
        ]);
    }
}