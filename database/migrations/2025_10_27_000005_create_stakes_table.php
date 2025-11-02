<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('staking_plans')->cascadeOnDelete();
            $table->unsignedBigInteger('amount')->default(0); // smallest unit
            $table->bigInteger('amount_usd_cents')->nullable(); // fiat equivalent at deposit time
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_payout_at')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled', 'paused'])->default('active'); // active, completed, cancelled, paused
            $table->json('meta')->nullable(); // validator pool id, auto-assigned pool info, etc.
            $table->timestamps();

            $table->index(['user_id', 'plan_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('stakes');
    }
};
