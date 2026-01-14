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
            $table->renameColumn('amount_usd_cents', 'capital');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stakes', function (Blueprint $table) {
            $table->renameColumn('capital', 'amount_usd_cents');
        });
    }
};
