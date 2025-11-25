<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->foreignId('wallet_id')->nullable()->after('confirmed_at')->constrained('wallets')->nullOnDelete();
            $table->string('currency', 30)->after('wallet_id');
            $table->decimal('amount_usd', 36, 8)->nullable()->after('currency');
            $table->string('nowpayments_invoice_id')->nullable()->after('amount_usd');
            $table->string('tx_id')->nullable()->after('nowpayments_invoice_id');
            $table->timestamp('processed_at')->nullable()->after('confirmations');
        });

        Schema::table('stakes', function (Blueprint $table) {
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->decimal('amount_usd', 36, 8)->nullable();
            $table->decimal('accumulated_rewards', 36, 18)->default(0);
            $table->boolean('compounding')->default(false);
            // $table->string('pool_id')->nullable();
        });
    }

    public function down(): void {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['currency', 'amount_usd', 'nowpayments_invoice_id', 'tx_id', 'confirmations', 'processed_at']);


            if (Schema::hasColumn('deposits', 'wallet_id')) {
                $table->dropConstrainedForeignId('wallet_id');
            }
        });

        Schema::table('stakes', function (Blueprint $table) {
            $table->dropColumn(['amount_usd', 'accumulated_rewards', 'compounding']);


            if (Schema::hasColumn('deposits', 'wallet_id')) {
                $table->dropConstrainedForeignId('wallet_id');
            }
        });
    }
};
