<?php

namespace App\Livewire\Dashboard\Affiliate;

use App\Models\Stake;
use App\Models\StakingPlan;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class ReferralCenter extends Component {

    public function render() {
        return view('livewire.dashboard.affiliate.referral-center');
    }
}
