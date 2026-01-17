<?php

namespace App\Services;

use App\Models\StakingPlan;
use App\Models\User;
use App\Models\ValidatorBlock;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ValidatorBlockService {
    public static function createRandomBlock(): ValidatorBlock {

        return DB::transaction(function () {

            $plans = StakingPlan::select('id', 'max_amount')
                ->where('max_amount', '>', 0)
                ->get();

            $totalWeight = $plans->sum('max_amount');

            if ($totalWeight <= 0) {
                throw new \Exception('No valid staking plans available');
            }

            $random = random_int(1, $totalWeight);

            $running = 0;

            $validator = $plans->first(function ($plan) use (&$running, $random) {
                $running += $plan->max_amount;
                return $running >= $random;
            });


            $validator = StakingPlan::where('id', $validator->id)
                ->lockForUpdate()
                ->first();

            return ValidatorBlock::create([
                'validator_id' => $validator->id,
                'block_hash'   => Str::uuid()->toString(),
                'status' => 'validated',
                'validated_at' => now()->addMinutes(5)
            ]);
        });
    }

    protected static function nextBlockNumber(): int
    {
        return (ValidatorBlock::max('block_number') ?? 0) + 1;
    }
}
