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

            $validator = StakingPlan::query()
                ->select('*')
                ->orderByRaw('RAND() * maximum_amount DESC')
                ->lockForUpdate()
                ->firstOrFail();

            return ValidatorBlock::create([
                'validator_id' => $validator->id,
                'block_hash'   => Str::uuid()->toString(),
                'block_number' => self::nextBlockNumber(),
                'status' => 'validated'
            ]);
        });
    }

    protected static function nextBlockNumber(): int
    {
        return (ValidatorBlock::max('block_number') ?? 0) + 1;
    }
}
