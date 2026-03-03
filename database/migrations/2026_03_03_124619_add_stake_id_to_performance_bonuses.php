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
        Schema::table('performance_bonuses', function (Blueprint $table) {
            $table->foreignId('stake_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->index('stake_id');

            $table->unique([
                'user_id',
                'source_user_id',
                'stake_id',
                'level',
                'bonus_date'
            ], 'unique_identifiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonuses', function (Blueprint $table) {
            $table->dropColumn('stake_id');
        });
    }
};
