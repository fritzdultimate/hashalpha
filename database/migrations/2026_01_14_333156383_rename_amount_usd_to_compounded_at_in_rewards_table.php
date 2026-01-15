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
            $table->renameColumn('amount_usd', 'compounded_at');
        });
        Schema::table('rewards', function (Blueprint $table) {
            $table->timestamp('compounded_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->string('compounded_at')->nullable()->change();
        });

        Schema::table('rewards', function (Blueprint $table) {
            $table->renameColumn('compounded_at', 'amount_usd');
        });
    }
};
