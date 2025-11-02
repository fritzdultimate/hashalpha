<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->unsignedBigInteger('amount')->default(0); // smallest unit
            $table->bigInteger('amount_usd_cents')->nullable();
            $table->string('address')->nullable();
            $table->string('tx_hash')->nullable()->index();
            $table->unsignedInteger('confirmations')->default(0);
            $table->enum('status', ['pending', 'confirmed', 'failed', 'cancelled', 'partially_paid'])->default('pending');
            $table->json('meta')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id','status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('deposits');
    }
};
