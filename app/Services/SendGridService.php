<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use SendGrid;

class SendGridService {
    public static function client(): SendGrid {
        return new SendGrid(config('services.sendgrid.api_key'));
    }

    public static function templates() {
        return Cache::remember('sendgrid:templates', 30 * 60, function () {
            $sg = self::client();

            $response = $sg->client->templates()->get(null, [
                'generations' => 'dynamic',
            ]);

            $templates = json_decode($response->body(), true)['templates'] ?? [];

            return collect($templates)->mapWithKeys(fn ($t) => [
                $t['id'] => $t['name'],
            ]);
        });
    }
}
