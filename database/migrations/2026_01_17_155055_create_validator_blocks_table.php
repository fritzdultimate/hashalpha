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
        Schema::create('validator_blocks', function (Blueprint $table) {
            $table->id();
             $table->foreignId('validator_id')
                ->constrained('staking_plans')
                ->cascadeOnDelete();
            $table->string('block_hash')->unique();
            $table->enum('status', ['pending', 'validated', 'failed'])
                ->default('pending');
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_blocks');
    }
};
