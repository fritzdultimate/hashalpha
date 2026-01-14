<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('referral_rewards', function (Blueprint $table) {
            $table->timestamp('claimable_at')->nullable()->after('calculated_for');
            $table->timestamp('claimed_at')->nullable()->after('claimable_at');
            $table->string('lock_reason')->nullable()->after('status');
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'balance',
            ]);
        });
    }
};
