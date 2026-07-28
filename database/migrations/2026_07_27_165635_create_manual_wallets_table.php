<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manual_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('currency');       // e.g. ETH, USDT
            $table->string('label');          // e.g. "Ethereum", "Tether"
            $table->string('network')->nullable(); // e.g. ERC20, TRC20
            $table->string('address');
            $table->string('qr_code_path')->nullable();
            $table->decimal('min_amount', 20, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_wallets');
    }
};
