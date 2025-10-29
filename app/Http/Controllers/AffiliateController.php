<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller {
    public function index() {
        // Data used on the index page overview (could come from DB later)
        $ranks = $this->ranksData();
        return view('landing.affiliate.index', compact('ranks'));
    }

    public function ranks() {
        $ranks = $this->ranksData();
        return view('landing.affiliate.ranks', compact('ranks'));
    }

    public function compensation() {
        // Add dynamic compensation details if needed
        return view('landing.affiliate.compensation');
    }

    public function tools() {
        // Serve banners, sample links, asset list
        return view('landing.affiliate.tools');
    }

    private function ranksData() {
        return [
            ['rank'=>'Starter','team_volume'=>'$5,000','personal_deposit'=>'$500','direct_referrals'=>2,'cash_bonus'=>'$150'],
            ['rank'=>'Bronze','team_volume'=>'$15,000','personal_deposit'=>'$1,000','direct_referrals'=>3,'cash_bonus'=>'$500'],
            ['rank'=>'Silver','team_volume'=>'$50,000','personal_deposit'=>'$2,000','direct_referrals'=>5,'cash_bonus'=>'$1,000'],
            ['rank'=>'Gold','team_volume'=>'$150,000','personal_deposit'=>'$5,000','direct_referrals'=>6,'cash_bonus'=>'$5,000'],
            ['rank'=>'Platinum','team_volume'=>'$500,000','personal_deposit'=>'$10,000','direct_referrals'=>8,'cash_bonus'=>'$10,000'],
            ['rank'=>'Ruby','team_volume'=>'$1,000,000','personal_deposit'=>'$15,000','direct_referrals'=>10,'cash_bonus'=>'$50,000'],
            ['rank'=>'Emerald','team_volume'=>'$2,500,000','personal_deposit'=>'$25,000','direct_referrals'=>12,'cash_bonus'=>'$100,000'],
            ['rank'=>'Diamond','team_volume'=>'$5,000,000','personal_deposit'=>'$50,000','direct_referrals'=>15,'cash_bonus'=>'$250,000'],
            ['rank'=>'Titan','team_volume'=>'$10,000,000','personal_deposit'=>'$100,000','direct_referrals'=>20,'cash_bonus'=>'$500,000'],
            ['rank'=>'Royal Alpha','team_volume'=>'$25,000,000','personal_deposit'=>'$150,000','direct_referrals'=>25,'cash_bonus'=>'$1,000,000'],
            ['rank'=>'Global Director','team_volume'=>'$50,000,000','personal_deposit'=>'$200,000','direct_referrals'=>30,'cash_bonus'=>'$2,000,000'],
        ];
    }
}
