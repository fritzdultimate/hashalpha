<?php

namespace App\Services;

use SendGrid;

class SendGridService {
    public static function client(): SendGrid {
        return new SendGrid(config('services.sendgrid.api_key'));
    }

    public static function templates() {
        $sg = self::client();
        $response = $sg->client->templates()->get(null, [
            'generations' => 'dynamic',
        ]);


        return collect(json_decode($response->body(), true)['templates'])
            ->mapWithKeys(fn ($t) => [
                $t['id'] => $t['name'],
            ]);
    }
}
