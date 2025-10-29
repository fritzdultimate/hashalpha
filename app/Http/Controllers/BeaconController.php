<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BeaconController extends Controller
{
    /**
     * Returns normalized beacon data from public providers with caching & fallback.
     */
    public function publicStatus(Request $req) {
        // cache key & TTL (seconds)
        $cacheKey = 'beacon:public:status';
        $ttl = 12; // seconds - adjust as you need (10-30s typical)

        // return cached if available
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return response()->json($cached);
        }

        // list of provider adapters (priority order)
        $providers = [
            'beaconcha' => [
                'url' => env('BEACONCHA_BASE', null), // e.g. https://beaconcha.in/api/v1
                'key_env' => 'BEACONCHA_API_KEY', // if needed
            ],
            'beaconscan' => [
                'url' => env('BEACONSCAN_BASE', null),
                'key_env' => 'BEACONSCAN_API_KEY',
            ],
            // add more providers here...
        ];

        $result = null;
        foreach ($providers as $name => $cfg) {
            if (empty($cfg['url'])) continue;

            try {
                // Build request: NOTE - this is provider-specific.
                // You must replace the path and parse logic below with actual provider paths.
                // Example: a provider that exposes a "status" or "head" endpoint.
                $base = rtrim($cfg['url'], '/');

                // Example attempt #1: a provider that offers a "head" summary endpoint
                // You must update this to match the actual provider API.
                $res = Http::withHeaders($this->providerHeaders($cfg['key_env']))->timeout(6)->get("$base/status");
                if (!$res->ok()) {
                    // Try another common endpoint pattern (some providers use /eth/v1/beacon/headers/head)
                    $res = Http::withHeaders($this->providerHeaders($cfg['key_env']))->timeout(6)->get("$base/eth/v1/beacon/headers/head");
                }

                if (!$res->ok()) {
                    // try next provider
                    continue;
                }

                $json = $res->json();

                // Normalize according to provider
                // IMPORTANT: You must adapt this parsing for the actual provider you choose.
                // Below are conservative examples and fallbacks.
                $normalized = $this->normalizeProviderResponse($name, $json);

                if ($normalized) {
                    $normalized['raw_provider'] = $name;
                    $normalized['fetched_at'] = now()->toISOString();

                    // cache & return
                    Cache::put($cacheKey, $normalized, $ttl);
                    $result = $normalized;
                    break;
                }

            } catch (\Throwable $e) {
                Log::warning("Beacon provider {$name} failed: " . $e->getMessage());
                // try next provider
                continue;
            }
        }

        if (!$result) {
            // if we reach here, no provider succeeded => try returning stale cache if available
            if ($cached) {
                return response()->json($cached);
            }
            return response()->json(['error' => 'No beacon provider available'], 503);
        }

        return response()->json($result);
    }

    private function providerHeaders($keyEnv) {
        $headers = [];
        if ($keyEnv && env($keyEnv)) {
            $headers['Authorization'] = 'Bearer ' . env($keyEnv);
        }
        return $headers;
    }

    /**
     * Map provider-specific JSON to canonical format.
     * YOU MUST ADJUST the parsing rules to the real provider responses.
     */
    private function normalizeProviderResponse(string $provider, array $json) {
        switch ($provider) {
            case 'beaconcha':
                // Example: some beaconcha endpoints may return structure like ['data' => ['head' => [...]]]
                // Replace keys below with the actual response fields from the provider you choose.
                // Conservative attempt:
                $headSlot = data_get($json, 'data.header.message.slot') ?? data_get($json, 'data.slot') ?? data_get($json, 'data.head.slot');
                $finalizedEpoch = data_get($json, 'data.finalized.epoch') ?? data_get($json, 'data.finalized_epoch');
                return [
                    'head_slot' => $headSlot,
                    'finalized_epoch' => $finalizedEpoch,
                    'meta' => $json,
                ];

            case 'beaconscan':
                // Adjust parsing based on beaconscan response structure
                $headSlot = data_get($json, 'head.slot') ?? data_get($json, 'data.head.slot');
                $finalizedEpoch = data_get($json, 'finalized.epoch') ?? data_get($json, 'data.finalized.epoch');
                return [
                    'head_slot' => $headSlot,
                    'finalized_epoch' => $finalizedEpoch,
                    'meta' => $json,
                ];

            default:
                return null;
        }
    }
}
