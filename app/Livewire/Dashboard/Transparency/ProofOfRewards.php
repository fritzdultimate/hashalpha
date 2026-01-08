<?php

namespace App\Livewire\Dashboard\Transparency;

use App\Models\Stake;
use App\Models\StakingPlan;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class ProofOfRewards extends Component {

    public $claimable = 100;

    public function render() {
        return view('livewire.dashboard.transparency.proof-of-rewards');
    }
}
