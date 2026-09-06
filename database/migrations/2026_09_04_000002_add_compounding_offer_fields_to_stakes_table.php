<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('stakes', function (Blueprint $table) {
            // Distinct from the pre-existing `compounding` flag (set when a single
            // reward or "compound all" is reinvested mid-stake) -- this marks a
            // stake that IS the locked term created by accepting a compounding
            // offer, so withdrawal-locking can target it specifically without
            // also catching ordinary reward reinvestment.
            $table->boolean('is_compounding_offer')->default(false)->after('compounding');
            $table->boolean('notify_daily')->default(false)->after('is_compounding_offer');
        });
    }

    public function down(): void {
        Schema::table('stakes', function (Blueprint $table) {
            $table->dropColumn(['is_compounding_offer', 'notify_daily']);
        });
    }
};
