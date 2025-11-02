<?php
namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
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
class ResetPassword extends Component {
    public $password = '';
    public $password_confirmation = '';
    public $remember = false;
    public $show2fa = false;
    public $userIdFor2fa;

    protected $rules = [
        'password' => 'required|min:6|confirmed',
    ];

    public function mount() {
        $userId = session('forget_password_id');
        abort_unless($userId, 403, 'No session found.');
    }

    public function submit() {
        $userId = session('forget_password_id');
        $key = 'reset-password:' . ($userId ?? 'guest:' . request()->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'password' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }
        $this->validate();

        $user = User::find($userId);
        if (! $user) {
            RateLimiter::hit($key, 60 * 5);
            abort(404, 'User not found.');
        }

        try {
            $user->password = Hash::make($this->password);
            $user->setRememberToken(Str::random(60));
            if (method_exists($user, 'markEmailAsVerified')) {
                $user->markEmailAsVerified();
            }
            $user->save();

            RateLimiter::clear($key);
            session()->forget('forget_password_id');

            $this->dispatch('toast', message: 'Password reset successful. Please sign in.', type: 'success');
            return redirect()->route('login')->with('success', 'Password reset successful. Please sign in.');
        } catch (\Throwable $e) {
            RateLimiter::hit($key, 60 * 5);
            throw ValidationException::withMessages([
                'password' => "Could not reset password. Please try again.",
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
