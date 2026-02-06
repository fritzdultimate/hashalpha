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
        Schema::create('loyalty_multipliers', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('hashalpha');

            $table->unsignedInteger('cycle');

            $table->decimal('bonus_percent', 5, 3);

            $table->string('title')->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['platform', 'cycle']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_multipliers');
    }
};
