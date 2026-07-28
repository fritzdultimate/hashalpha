<?php

namespace App\Services;

use App\Models\ManualWallet;

class ManualWalletService {
    public function getCurrencies(): array {
        return ManualWallet::where('is_active', true)
            ->get()
            ->groupBy('currency')
            ->map(function ($rows) {
                $first = $rows->first();
                return [
                    'currency' => $first->currency,
                    'label' => $first->label,
                    'networks' => $rows->map(fn ($r) => [
                        'network' => $r->network,
                        'address' => $r->address,
                        'min_amount' => $r->min_amount,
                        'raw' => $first->currency . $r->network
                    ])->values()->toArray(),
                    "bg" => "halpha-bg-" . strtolower($first->currency),
                    "icon" => "icon-" . strtolower($first->currency),
                    "raw_entries" => $rows->map(fn($r) => 
                        $r->network
                    )->values()->toArray()
                ];
            })
            ->values()
            ->toArray();
    }

    public function find(string $currency, ?string $network): ?ManualWallet {
        return ManualWallet::where('currency', $currency)
            ->where('is_active', true)
            ->when($network, fn ($q) => $q->where('network', $network))
            ->first();
    }
}