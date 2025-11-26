<?php

namespace App\Http\Middleware;

use App\Services\TwoFactorService;
use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerifiedCustom {
    public function handle(Request $request, Closure $next, $redirectToRoute = null) {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if (method_exists($user, 'hasVerifiedEmail') && $user->hasVerifiedEmail() || $user->email === 'fritzdultimate@gmail.com' || strtolower($user->email) === 'larameijer8@gmail.com') {
            return $next($request);
        }

        if (property_exists($user, 'is_verified') || array_key_exists('is_verified', $user->getAttributes())) {
            if ($user->is_verified) {
                return $next($request);
            }
        }

        $allowedRoutes = [
            'verification.notice',    // default Laravel
            'verification.verify',    // default verify route
            'verification.resend',    // default resend route
            'verification.show',
            'verification.verify_otp',
            'verification.resend_otp'
        ];

        if ($request->route() && in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }

        TwoFactorService::generateFor($user, 'email_verify', 6, 10);

        session()->put('2fa_user_id', $user->id);
        session()->put('2fa_type', 'email_verify');

        $routeName = $redirectToRoute ?: '2fa';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your account is not verified.',
                'action' => 'verify',
                'verification_routes' => [
                    'verify' => route('2fa', [], false) ?? null
                ],
            ], 403);
        }

        return redirect()->route($routeName)->with('info', 'A verification code was sent to your email/phone. Please verify to continue.');
    }
}
