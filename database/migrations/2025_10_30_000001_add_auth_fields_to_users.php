<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_verified')->default(false);
            $table->boolean('two_factor_enabled')->default(false);
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_until')->nullable();
            $table->integer('failed_logins')->default(0);
            $table->timestamp('last_failed_at')->nullable();
            $table->string('two_factor_channel')->nullable(); // 'sms' or 'email' if you want per-user channel
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_verified',
                'two_factor_enabled',
                'is_suspended',
                'suspended_until',
                'failed_logins',
                'last_failed_at',
                'two_factor_channel',
            ]);
        });
    }
};
