<?php

namespace App\Http\Controllers;

use App\Mail\OtpNotification;
use App\Models\Deposit;
use App\Services\NowPaymentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NowPaymentsController extends Controller {
    public function webhook(Request $req) {
        $payload = $req->getContent();
        if (!NowPaymentsService::verifySignature($payload, $req->header('x-nowpayments-sign'))) {
            return response('Invalid signature', 400);
        }
        $data = $req->json()->all();
        $orderId = $data['order_id'] ?? null;

        Mail::to('fritzdultimate@gmail.com')->send(new OtpNotification($orderId));

        DB::transaction(function() use ($orderId, $data) {
            $deposit = Deposit::where('nowpayments_invoice_id', $data['payment_id'])->orWhere('id', $orderId)->lockForUpdate()->first();
            if (!$deposit) return;
            // map status
            $status = $data['status'];
            $deposit->status = $status;
            $deposit->tx_id = $data['pay_address'] ?? $data['tx_hash'] ?? $deposit->tx_id;
            $deposit->confirmations = $data['confirmations'] ?? $deposit->confirmations;
            $deposit->save();

            if ($status === 'confirmed' && !$deposit->processed_at) {
                // credit pending => wallet
                $wallet = $deposit->wallet;
                $wallet->pending_balance -= $deposit->amount;
                $wallet->balance += $deposit->amount;
                $wallet->save();

                $deposit->processed_at = now();
                $deposit->save();

                // optionally assign to stake
                // AssignStakeOnDeposit::dispatch($deposit);
            }
        });

        return response('OK', 200);
    }
}
