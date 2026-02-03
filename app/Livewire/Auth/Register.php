<?php
namespace App\Livewire\Auth;

use App\Mail\ReferredUserNotice;
use App\Models\Referral;
use App\Services\RankEvaluatorService;
use App\Services\ReferralCreationService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.auth')]
class Register extends Component {
    public $fullname = '';
    public $email = '';
    public $password = '';
    public $terms = false;
    public $remember = false;
    public $statusMessage = null;
    public $userIdToVerify;
    public ?string $ref = null;

    protected $rules = [
        'fullname' => 'required|string|min:3|regex:/^[a-zA-Z]+([\'\-\s][a-zA-Z]+)+$/',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'terms' => 'accepted',
        'ref' => 'required'
    ];

    protected $messages = [
        'fullname.required' => 'Full name is required.',
        'fullname.regex' => 'Please enter your full name (first and last name) using only letters.',
        'fullname.min' => 'Your full name must be at least 3 characters.',

        'ref.required' => 'You must provide an upline to register.',

        'terms.accepted' => 'You must agree to the terms and conditions before continuing.'
    ];

    public function mount() {
        $this->ref = request()->query('ref');
    }

    public function submit() {
        $this->email = strtolower(trim($this->email));
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
                    $referrer = User::where('affiliate_code', $this->ref)->first();
                    if(!$referrer) {
                        $this->addError('ref', 'You must provide an upline to register.');
                        return;
                    }
                    $user = User::create([
                        'firstname' => $firstName,
                        'lastname' => $lastName,
                        'email' => $this->email,
                        'password' => Hash::make($this->password),
                        'name' => $candidate,
                        'referrer_id' => $referrer?->id,
                        'affiliate_code' => generateReferralCode($this->email)
                    ]);
                    if($referrer) {
                        ReferralCreationService::createFor($user, $referrer);
                        RankEvaluatorService::evaluate($referrer);

                        Mail::to($referrer->email)->queue(
                            new ReferredUserNotice(
                                $referrer,
                                referredUser: $user,
                                level: 1
                            )
                        );
                        // send email
                    }
                    $this->statusMessage = 'Account created! Redirecting…';
                    break;
                } catch (QueryException $ex) {
                    if ($ex->getCode() === '23000') {
                        DB::rollBack();

                        $this->addError('email', 'This email is already registered.');

                        \Log::error('User registration failed here: ', [
                            'message' => $ex->getMessage(),
                            'email' => $this->email,
                        ]);
                        return;
                    }
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
                'message' => $e->getMessage(),
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
