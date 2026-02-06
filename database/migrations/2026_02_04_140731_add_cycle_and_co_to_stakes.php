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
        Schema::table('stakes', function (Blueprint $table) {
            $table->unsignedInteger('cycle')->default(1)->after('capital');
            $table->timestamp('last_completed_at')->nullable()->after('cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stakes', function (Blueprint $table) {
            $table->dropColumn(['cycle', 'last_completed_at']);
        });
    }
};
