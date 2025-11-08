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
class Login extends Component {
    public $email = '';
    public $password = '';
    public $remember = false;
    public $show2fa = false;
    public $userIdFor2fa;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function login() {
        $this->validate();
        session()->put('2fa_user_id', 'login');

        // throttle key (by email + ip)
        $key = Str::lower($this->email).'|'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 4)) {
            throw ValidationException::withMessages(['email' => 'Too many attempts. Please try again later.']);
        }

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
        }

        // suspended?
        if ($user->is_suspended && $user->suspended_until && now()->lessThan($user->suspended_until)) {
            throw ValidationException::withMessages(['email' => "Account is on hold. Please try again in " . remaining_time_until($user->suspended_until)]);
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($key, 60);
            LoginGuardService::recordFailedAttempt($user);
            throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
        }

        
        LoginGuardService::resetFailures($user);
        RateLimiter::clear($key);

        
        if ($user->two_factor_enabled) {
            TwoFactorService::generateFor($user, 'login', 6, 10);

            // $user->notify(new \App\Notifications\TwoFactorCodeNotification($codeRow->code));

            session()->put('2fa_user_id', $user->id);
            session()->put('2fa_type', 'login');

            return redirect()->route('2fa');
        }

        auth()->loginUsingId($user->id, $this->remember);
        session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function render() {
        return view('livewire.auth.login');
    }
}
