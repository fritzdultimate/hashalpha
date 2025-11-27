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
        $signature = $req->header('x-nowpayments-sig');

        if (!$signature) {
            return response('Invalid signature', 400);
        }

        if (!NowPaymentsService::verifySignature($payload, $signature)) {
            return response('Invalid signature', 400);
        }

        $data = $req->json()->all();
        $orderId = $data['order_id'] ?? null;

        DB::transaction(function() use ($orderId, $data) {
            $deposit = Deposit::where('nowpayments_invoice_id', $data['payment_id'])->orWhere('id', $orderId)->lockForUpdate()->first();
            if (!$deposit) return;
            
            $status = $data['payment_status'];
            $deposit->status = $status;
            $deposit->tx_id = $data['pay_address'] ?? $data['tx_hash'] ?? $deposit->tx_id;
            $deposit->confirmations = $data['confirmations'] ?? $deposit->confirmations;
            $deposit->save();

            if ($status === 'confirmed' && !$deposit->processed_at) {
                // $wallet = $deposit->wallet;
                // $wallet->pending_balance -= $deposit->amount;
                // $wallet->balance += $deposit->amount;
                // $wallet->save();

                $deposit->processed_at = now();
                $deposit->save();

                // AssignStakeOnDeposit::dispatch($deposit);
            }
        });

        return response('OK', 200);
    }
}
