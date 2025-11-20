<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stake_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 36, 18);
            $table->decimal('amount_usd', 36, 8)->nullable();
            $table->string('reward_type'); // staking|affiliate|matching
            $table->integer('level')->nullable();
            $table->foreignId('source_user_id')->nullable()->constrained('users');
            $table->string('status')->default('pending'); // pending|credited|paid
            $table->timestamp('credited_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rewards');
    }
};
