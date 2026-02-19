<?php

namespace App\Http\Controllers;
use App\Services\LeaderBoardService;


class LeaderBoardController extends Controller {
    public function leaderBoardEntry() {
        LeaderBoardService::scoreLeaderBoard();
    }
}
