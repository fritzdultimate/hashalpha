<?php

namespace App\Livewire;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class OtpInput extends Component {

    #[Modelable]
    public $otp = '7777';

    public function updatedOtp() {
        $this->otp = substr(preg_replace('/\D/', '', $this->otp), 0, 4);
    }
    public function render() {
        return view('livewire.otp-input');
    }
}
