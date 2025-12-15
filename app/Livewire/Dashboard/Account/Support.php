<?php

namespace App\Livewire\Dashboard\Account;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Support extends Component {
    public $subject, $message;


    public function submit()
    {
        $this->validate([
            'subject' => 'required',
            'message' => 'required|min:10'
        ]);


        // create ticket
    }


    public function render(){
        return view('livewire.dashboard.account.support');
    }
}