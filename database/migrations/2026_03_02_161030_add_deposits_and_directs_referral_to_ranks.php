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
        Schema::table('ranks', function (Blueprint $table) {
            $table->decimal('deposits', 20, 8)->default(500);
            $table->unsignedInteger('direct_referrals')->default(15);
            $table->boolean('global_override')->default(false);
            $table->boolean('global_pool_share')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranks', function (Blueprint $table) {
            $table->dropColumn(['deposits', 'direct_referrals']);
        });
    }
};
