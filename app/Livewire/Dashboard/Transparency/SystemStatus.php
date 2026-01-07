<?php

namespace App\Livewire\Dashboard\Transparency;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SystemStatus extends Component
{
    public function render() {
        return view('livewire.dashboard.transparency.system-status');
    }
}
