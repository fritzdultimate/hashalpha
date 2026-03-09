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
        Schema::table('challenge_entries', function (Blueprint $table) {
            $table->integer('previous_rank')->nullable()->after('rank');
            $table->integer('rank_change')->default(0)->after('previous_rank');
            $table->integer('phase')->after('rank_change')->default(1);
        });

        Schema::table('challenge_forty_eight_entries', function (Blueprint $table) {
            $table->integer('previous_rank')->nullable()->after('rank');
            $table->integer('rank_change')->default(0)->after('previous_rank');
            $table->integer('phase')->after('rank_change')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenge_entries', function (Blueprint $table) {
            //
        });
    }
};
