<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Models\ValidatorReward;
use App\Services\NowPaymentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateValidatorReward extends Controller {
    public function handle() {
        $count = ValidatorReward::count();
        $amount = bcdiv(
            rand(1, 30),
            1000,
            8
        );

        ValidatorReward::create([
            'reward_date' => now(),
            'amount' => $amount,
            'status' => 'pending',
            'source' => 'validator_reward',
        ]);
    }
}
