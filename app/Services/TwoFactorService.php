<?php
namespace App\Services;

use App\Mail\OtpNotification;
use App\Models\TwoFactorCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TwoFactorService {
    public static function generateFor($user, $type = 'login', $length = 6, $ttlMinutes = 10) {
        $code = (string) rand(pow(10, $length-1), pow(10, $length)-1);
        // delete previous of same type
        TwoFactorCode::where('user_id', $user->id)->where('type', $type)->delete();

        Mail::to($user->email)->queue(new OtpNotification(
            otp: $code
        ));
        return TwoFactorCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes($ttlMinutes),
        ]);
    }

    public static function validate($user, $code, $type = 'login') {
        $row = TwoFactorCode::where('user_id', $user->id)
            ->where('type', $type)
            ->orderByDesc('id')
            ->first();
        if (!$row) return false;
        if ($row->isExpired()) {
            $row->delete();
            return false;
        }
        if (!hash_equals($row->code, $code)) {
            return false;
        }
        $row->delete();
        return true;
    }
}
