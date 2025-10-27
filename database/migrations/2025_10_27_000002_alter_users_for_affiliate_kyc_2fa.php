<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Affiliates & referral
            $table->string('affiliate_code', 48)->nullable()->unique()->after('remember_token');
            $table->foreignId('referrer_id')->nullable()->after('affiliate_code')->constrained('users')->nullOnDelete();

            // KYC & 2FA
            $table->enum('kyc_status', ['unsubmitted', 'pending', 'approved', 'rejected'])->default('unsubmitted')->after('referrer_id');
            $table->timestamp('kyc_submitted_at')->nullable()->after('kyc_status');
            $table->boolean('is_2fa_enabled')->default(false)->after('kyc_submitted_at');

            // Soft block for sanctions/holds
            $table->timestamp('blocked_at')->nullable()->after('is_2fa_enabled');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['affiliate_code', 'kyc_status', 'kyc_submitted_at', 'is_2fa_enabled', 'blocked_at']);
            // drop foreign key and column separately to be safe
            if (Schema::hasColumn('users', 'referrer_id')) {
                $table->dropConstrainedForeignId('referrer_id');
            }
        });
    }
};
