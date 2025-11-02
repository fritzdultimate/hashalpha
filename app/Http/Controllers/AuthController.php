<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $credentials = $r->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        // Attempt auth
        if (!Auth::attempt($credentials, $r->filled('remember'))) {
            return back()->withErrors(['email'=>'Invalid credentials'])->withInput();
        }

        $user = Auth::user();

        // If user has 2FA enabled, generate code and redirect to 2fa page
        if ($user->two_factor_enabled) {
            $code = rand(100000,999999);
            $user->forceFill(['two_factor_code' => bcrypt($code), 'two_factor_expires_at'=> now()->addMinutes(10)])->save();

            // Send code via mail (example). Replace with SMS or TOTP as needed.
            Mail::to($user->email)->queue(new TwoFactorCode($code));

            // Log the user out from session until 2FA verified but keep user id in session
            Auth::logout();
            session(['2fa:user:id' => $user->id, '2fa:remember' => $r->filled('remember')]);

            return redirect()->route('2fa')->with('info','A verification code was sent to your email.');
        }

        // Normal successful login
        $r->session()->regenerate();
        return redirect()->intended('/');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()],
            'terms' => ['accepted']
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            // 'two_factor_enabled' => false by default
        ]);

        Auth::login($user);
        return redirect()->intended('/');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $r)
    {
        $r->validate(['email'=>'required|email']);
        $status = Password::sendResetLink($r->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showReset($token)
    {
        return view('auth.reset', ['token'=>$token]);
    }

    public function resetPassword(Request $r)
    {
        $r->validate([
            'token'=>'required',
            'email'=>'required|email',
            'password'=>['required','confirmed', PasswordRule::min(8)->mixedCase()->numbers()],
        ]);

        $status = Password::reset(
            $r->only('email','password','password_confirmation','token'),
            function ($user,$password) {
                $user->forceFill(['password'=>Hash::make($password),'remember_token'=>Str::random(60)])->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status','Password reset successful. You can now login.')
            : back()->withErrors(['email'=>__($status)]);
    }

    public function showTwoFactor()
    {
        // require session id set by login flow
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }
        return view('auth.twofactor');
    }

    public function verifyTwoFactor(Request $r)
    {
        $r->validate(['code'=>'required|digits:6']);

        $userId = session('2fa:user:id');
        $remember = session('2fa:remember', false);
        if (!$userId) return redirect()->route('login');

        $user = User::find($userId);
        if (!$user) return redirect()->route('login');

        // Check code against hashed code
        if (!Hash::check($r->code, $user->two_factor_code ?? '')) {
            return back()->withErrors(['code'=>'Invalid code']);
        }

        if ($user->two_factor_expires_at && now()->gt($user->two_factor_expires_at)) {
            return back()->withErrors(['code'=>'Code expired. Please request a new code.']);
        }

        // Clear 2fa fields and login
        $user->forceFill(['two_factor_code'=>null,'two_factor_expires_at'=>null])->save();
        Auth::login($user, $remember);

        session()->forget(['2fa:user:id','2fa:remember']);

        return redirect()->intended('/');
    }

    public function showRecoveryCodes()
    {
        // Simple demo: generate recovery codes for user
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // In production, generate securely, store hashed, and show once.
        $codes = collect(range(1,8))->map(fn() => strtoupper(Str::random(8)))->toArray();

        return view('auth.recovery', ['codes'=>$codes]);
    }

    public function logout(Request $r) {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login');
    }
}
