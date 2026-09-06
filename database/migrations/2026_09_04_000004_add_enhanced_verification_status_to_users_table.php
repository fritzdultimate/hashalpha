<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('enhanced_verification_status')->default('unsubmitted')->after('kyc_submitted_at');
            // unsubmitted|pending|approved|rejected
            $table->timestamp('enhanced_verification_submitted_at')->nullable()->after('enhanced_verification_status');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['enhanced_verification_status', 'enhanced_verification_submitted_at']);
        });
    }
};
