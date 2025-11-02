<?php
namespace App\Livewire\Auth;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.auth')]
class Register extends Component {
    public $fullname = 'Nwosu Darlington';
    public $email = 'fritzdultimate@gmail.com';
    public $password = '123456';
    public $terms = false;
    public $remember = false;
    public $statusMessage = null;
    public $userIdToVerify;

    protected $rules = [
        'fullname' => 'required|string|min:3|regex:/^[a-zA-Z]+([\'\-\s][a-zA-Z]+)+$/',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'terms' => 'accepted'
    ];

    protected $messages = [
        'fullname.required' => 'Full name is required.',
        'fullname.regex' => 'Please enter your full name (first and last name) using only letters.',
        'fullname.min' => 'Your full name must be at least 3 characters.',

        'terms.accepted' => 'You must agree to the terms and conditions before continuing.'
    ];

    public function submit() {
        $this->validate();

        $fullname = trim($this->fullname ?? '');
        $nameParts = preg_split('/\s+/', $fullname, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName  = $nameParts[1] ?? '';

        $local = Str::before($this->email, '@');
        $usernameBase = Str::slug($local ?: 'user', '_');

        if (empty($usernameBase)) {
            $usernameBase = 'user';
        }

        $maxLength = 15;
        $usernameBase = Str::limit($usernameBase, $maxLength, '');

        $user = null;
        $attempt = 0;
        $maxAttempts = 10;

        DB::beginTransaction();

        try {
            do {
                $attempt++;
                $candidate = $attempt === 1 ? $usernameBase : "{$usernameBase}_{$attempt}";

                if (strlen($candidate) > $maxLength) {
                    $suffixLen = strlen("_{$attempt}");
                    $candidate = Str::substr($usernameBase, 0, $maxLength - $suffixLen) . "_{$attempt}";
                }

                try {
                    $user = User::create([
                        'firstname' => $firstName,
                        'lastname'  => $lastName,
                        'email'     => $this->email,
                        'password'  => Hash::make($this->password),
                        'name'      => $candidate,
                    ]);
                    $this->statusMessage = 'Account created! Redirecting…';
                    break;
                } catch (QueryException $ex) {
                    if ($attempt >= $maxAttempts) {
                        throw $ex;
                    }
                    // otherwise loop and try next candidate
                }
            } while ($attempt < $maxAttempts);

            if (!$user) {
                throw new \RuntimeException('Unable to create user. Please try again.');
            }
            $row = TwoFactorService::generateFor($user, 'register', 6, 30);

            DB::commit();

            // Notify the user
            // $user->notify(new RegisterVerification($row->code));

            // Save 2FA details in session and redirect
            session()->put('2fa_user_id', $user->id);
            session()->put('2fa_type', 'register');

            return redirect()->route('2fa');
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('User registration failed: '.$e->getMessage(), [
                'email' => $this->email,
            ]);

            // Provide a friendly validation-like error to the user
            $this->addError('email', 'Registration failed. Please try again or contact support.');

            return;
        }
    }

    public function render() {
        return view('livewire.auth.register');
    }
}
