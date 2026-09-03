<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');

        if (empty($apiKey)) {
            return response()->json(['message' => 'API key is missing.'], 401);
        }

        $customer = Customer::where('api_key', $apiKey)->first();

        if (!$customer || !$customer->is_active) {
            return response()->json(['message' => 'Invalid API key.'], 401);
        }

        $requestHost = $this->resolveRequestHost($request);

        if (!$customer->domainIsAllowed($requestHost)) {
            return response()->json(['message' => 'This API key is not authorized for this domain.'], 403);
        }

        // Make the resolved customer available to the controller, e.g. $request->customer
        $request->attributes->set('customer', $customer);

        return $next($request);
    }

    /**
     * Pull the calling host out of the Origin header, falling back to Referer.
     * Both are set by browsers automatically; a plain server-to-server curl call
     * that sends neither will fail the domain check by design.
     */
    private function resolveRequestHost(Request $request): ?string
    {
        $origin = $request->headers->get('Origin');

        if ($origin) {
            return parse_url($origin, PHP_URL_HOST);
        }

        $referer = $request->headers->get('Referer');

        if ($referer) {
            return parse_url($referer, PHP_URL_HOST);
        }

        return null;
    }
}
