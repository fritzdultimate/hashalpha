<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\WithdrawalStatus;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount', 20, 8);
            $table->string('address');
            $table->string('network')->nullable();

            $table->string('status')
                ->default(WithdrawalStatus::PENDING->value);

            $table->string('tx_hash')->nullable();
            $table->text('failure_reason')->nullable();

            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
