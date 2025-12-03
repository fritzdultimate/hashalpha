<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class StakeDetails extends Component {
    public $selectedStakeId = null;
    public function goBack() {
        $this->dispatch('goBack', tab: 'list');
    }

    public function render() {
        return view('livewire.dashboard.stake-details');
    }
}
