<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('currency', 20);
            $table->string('address')->unique();
            $table->string('xpub')->nullable();
            $table->unsignedBigInteger('derivation_index')->nullable();
            $table->decimal('balance', 36, 18)->default(0);
            $table->decimal('pending_balance', 36, 18)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
