<?php
namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Services\TwoFactorService;
use App\Services\LoginGuardService;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

#[Layout('layouts.auth')]
class ForgotPassword extends Component {
    public $email = '';
    public $password = '';
    public $remember = false;
    public $show2fa = false;
    public $userIdFor2fa;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function send() {
        $user = User::where('email', $this->email)->first();

        if(!$user) {
            throw ValidationException::withMessages(['email' => 'Unknown account']);
        }

        TwoFactorService::generateFor($user, 'reset_password', 6, 10);
        // TODO: notify user: $this->user->notify(new TwoFactorCodeNotification($row->code));

        session()->put('2fa_user_id', $user->id);
        session()->put('2fa_type', 'reset_password');

        return redirect()->route('2fa');
    }

    public function render()
    {
        return view('livewire.auth.forget-password');
    }
}
