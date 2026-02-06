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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('deposit_wallet', 20, 8)
                ->default(0)
                ->after('balance');

            $table->decimal('stake_reward_wallet', 20, 8)
                ->default(0)
                ->after('deposit_wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['deposit_wallet', 'stake_reward_wallet']);
        });
    }
};
