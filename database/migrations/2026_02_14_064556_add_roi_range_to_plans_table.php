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
        Schema::table('staking_plans', function (Blueprint $table) {
            $table->decimal('min_roi', 5, 2)->after('daily_roi');
            $table->decimal('max_roi', 5, 2)->after('min_roi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['min_roi', 'max_roi']);
        });
    }
};
