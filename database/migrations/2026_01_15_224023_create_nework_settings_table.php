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
        Schema::create('nework_settings', function (Blueprint $table) {
            $table->id();

            // Validators
            $table->unsignedInteger('total_validators')->default(0);
            $table->unsignedInteger('active_validators')->default(0);

            // Uptime
            $table->decimal('network_uptime', 5, 2)->default(0);     // current %
            $table->decimal('uptime_90_days', 5, 2)->nullable();
            
            $table->string('distribution_frequency')->default('hourly');

            $table->decimal('profit_cap', 20, 8)->default(0.01);

            $table->decimal('profit_minimum', 20, 8)->default(0.0001);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nework_settings');
    }
};
