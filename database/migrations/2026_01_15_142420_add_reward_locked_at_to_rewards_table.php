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
        Schema::table('rewards', function (Blueprint $table) {
            $table->timestamp('rewards_locked_at')->nullable();
            $table->foreignId('rewards_locked_by')->nullable()->constrained('users');
            $table->text('lock_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn(['rewards_locked_at', 'rewards_locked_by', 'lock_reason']);
        });
    }
};
