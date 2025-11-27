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
        Schema::table('deposits', function (Blueprint $table) {
            $table->renameColumn('amount_usd_cents', 'note');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->string('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('note', 36, 8)->change();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->renameColumn('note', 'amount_usd_cents');
        });
    }
};
