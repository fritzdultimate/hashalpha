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
        Schema::table('kyc_verification', function (Blueprint $table) {
            // Drop selfie column
            if (Schema::hasColumn('kyc_verification', 'selfie')) {
                $table->dropColumn('selfie');
            }

            // Rename full_name to address
            if (Schema::hasColumn('kyc_verification', 'full_name')) {
                $table->renameColumn('full_name', 'address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_verification', function (Blueprint $table) {
            // Revert changes
            $table->string('selfie')->nullable();
            $table->renameColumn('address', 'full_name');
        });
    }
};
