<?php

namespace App\Livewire\Dashboard\Extras;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ComingSoon extends Component {


    public function render() {
        return view('livewire.dashboard.extras.coming-soon');
    }
}
