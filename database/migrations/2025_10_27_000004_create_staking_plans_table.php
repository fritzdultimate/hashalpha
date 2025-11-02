<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('staking_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->text('description')->nullable();
            // $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->unsignedBigInteger('min_amount')->default(0); // smallest unit
            $table->unsignedBigInteger('max_amount')->nullable(); // smallest unit
            $table->decimal('daily_roi', 8, 6)->default(0.000000); // e.g. 0.006 = 0.6%
            $table->enum('payout_frequency', ['hourly','daily', 'weekly', 'monthly', 'yearly'])->default('daily');
            $table->boolean('compound_allowed')->default(true);
            $table->json('rules')->nullable(); // e.g., lockup_days, early_withdraw_penalty, etc.
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('staking_plans');
    }
};
