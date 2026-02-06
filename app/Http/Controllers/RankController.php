<?php

namespace App\Http\Controllers;


use App\Models\Stake;
use App\Models\User;
use App\Services\RankEvaluatorService;

class RankController extends Controller {
    public function assignRank() {
        $users = User::all();

        foreach($users as $user) {
            RankEvaluatorService::evaluate($user);
        }
    }
}
