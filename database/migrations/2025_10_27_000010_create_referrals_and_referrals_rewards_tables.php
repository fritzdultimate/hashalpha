<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // affiliate links / codes
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('referred_by_id')->nullable()->constrained('users')->onDelete('set null');

            $table->foreignId('level_1_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_2_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_3_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_4_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_5_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_6_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_7_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_8_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_9_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('level_10_id')->nullable()->constrained('users')->onDelete('set null');

            $table->unsignedInteger('total_direct_referrals')->default(0);
            $table->unsignedInteger('total_downlines')->default(0);
            $table->decimal('total_earnings', 16, 2)->default(0);
            $table->timestamps();

            $table->index('user_id');
            $table->index('referred_by_id');
        });

        // referral rewards ledger
        Schema::create('referral_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // receiver of reward
            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete(); // origin of commission
            $table->unsignedTinyInteger('level')->default(1); // 1..10
            $table->unsignedInteger('percent_bps')->default(0); // basis points (10000 = 100%)
            $table->unsignedBigInteger('amount')->default(0); // smallest unit
            $table->bigInteger('amount_usd_cents')->nullable();
            $table->foreignId('stake_id')->nullable()->constrained('stakes')->nullOnDelete();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->json('meta')->nullable();
            $table->timestamp('calculated_for')->nullable(); // calculation date (day)
            $table->timestamps();

            $table->index(['user_id','status']);
            $table->index(['from_user_id','calculated_for']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('referrals_rewards');
        Schema::dropIfExists('referrals');
    }
};
