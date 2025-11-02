<?php
namespace App\Livewire\Auth;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use App\Services\TwoFactorService;

#[Layout('layouts.auth')]
class TwoFactor extends Component {
    public $code = '';
    public $user;
    public ?int $resendAvailableUntil = null;
    public $previousUrl = null;

    public function mount() {
        $this->previousUrl = request()->headers->get('referer');
        $this->payload = route('password.reset.request');
        $userId = session('2fa_user_id');
        abort_unless($userId, 403, 'No 2FA session found.');
        $this->user = User::find($userId);
        $this->resendAvailableUntil = session('resend_until') ? (int) session('resend_until') : null;
    }

    public function verify() {

        if (!$this->user) {
            return $this->addError('code', 'Invalid session.');
        }

        $ok = TwoFactorService::validate($this->user, $this->code, session('2fa_type','login'));
        if (!$ok) {
            $this->addError('code', 'Invalid or expired code.');
            return;
        }
        
        if($this->previousUrl && Str::startsWith($this->previousUrl, route('password.reset.request'))) {
            session()->put('forget_password_id', $this->user->id);
            return redirect()->route('password.reset');
        }
        session()->forget(['2fa_user_id','2fa_type']);
        auth()->user()->markEmailAsVerified();
        auth()->loginUsingId($this->user->id);
        return redirect()->intended('/dashboard');
    }

    public function resend() {
        if ($this->resendAvailableUntil && now()->timestamp < $this->resendAvailableUntil) {
            $this->dispatch('toast', message: 'Please wait before resending.', type: 'info', title: 'Hold on');
            return;
        }

        $row = TwoFactorService::generateFor($this->user, session('2fa_type','login'), 6, 10);
        // TODO: notify user: $this->user->notify(new TwoFactorCodeNotification($row->code));
        $this->dispatch('toast', message: 'Code resent.', type: 'success', title: 'Success');

        $cooldownSeconds = 30;
        $this->resendAvailableUntil = now()->addSeconds($cooldownSeconds)->timestamp;
        $this->dispatch('resend-start', until: $this->resendAvailableUntil);
        session()->put('resend_until', $this->resendAvailableUntil);
    }

    public function getResendDisabledProperty(): bool {
        return (bool) ($this->resendAvailableUntil && now()->timestamp < $this->resendAvailableUntil);
    }

    public function render() {
        return view('livewire.auth.two-factor');
    }
}
