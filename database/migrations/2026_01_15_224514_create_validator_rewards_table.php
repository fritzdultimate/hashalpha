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
        Schema::create('validator_rewards', function (Blueprint $table) {
            $table->id();
            $table->date('reward_date');

            $table->decimal('amount', 20, 8);
            $table->enum('status', ['pending', 'distributed', 'failed'])
                ->default('pending');
            $table->timestamps();
            $table->string('source')->default('validator_reward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_rewards');
    }
};
