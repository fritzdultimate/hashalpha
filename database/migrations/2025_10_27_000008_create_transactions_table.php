<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->enum('type', ['credit','debit','hold','release','fee'])->index();
            $table->unsignedBigInteger('amount')->default(0); // smallest unit
            $table->bigInteger('amount_usd_cents')->nullable();
            $table->unsignedBigInteger('balance_after')->default(0); // user's balance after tx (smallest unit)
            $table->string('related_type')->nullable(); // morphable: Deposit|Payout|Stake|Affiliate etc
            $table->unsignedBigInteger('related_id')->nullable();
            $table->json('meta')->nullable(); // reason, note, webhook payload, etc.
            $table->timestamps();

            $table->index(['user_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
