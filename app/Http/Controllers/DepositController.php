<?php

namespace App\Http\Controllers;

use App\Enums\DepositStatus;
use App\Models\Deposit;
use App\Services\NowPaymentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DepositController extends Controller {
    public function pollDeposit($id, NowPaymentsService $np) {
        $deposit = Deposit::findOrFail($id);

        $details = $np->getPaymentStatus($deposit->nowpayments_invoice_id);

        $deposit->status = $details["payment_status"] ?? $deposit->status;
        $deposit->tx_hash = $details["payin_hash"] ?? $deposit->tx_hash;
        $deposit->amount_paid = $details["actually_paid"] ?? $deposit->amount_paid;
        $deposit->save();

        $details["created_at"] = $deposit->created_at;


        return response()->json([
            'details' => $details
        ]);
    }

    public function cancelDeposit($id) {
        $deposit = Deposit::where([
            'user_id', auth()->id(),
            'id' => $id
        ])->first();

        if($deposit->status !== DepositStatus::FINISHED) {
            $deposit->status = DepositStatus::CANCELLED;
            $deposit->save();

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }
}
