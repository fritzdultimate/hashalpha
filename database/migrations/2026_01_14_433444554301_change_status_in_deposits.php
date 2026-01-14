<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('status')->nullable()->change();
        });
    }

    public function down() {
        Schema::table('deposits', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'failed', 'cancelled', 'partially_paid'])->default('pending');
        });
    }
};
