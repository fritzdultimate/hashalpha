<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('two_factor_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('code', 10);
            $table->string('type', 32)->default('login');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('two_factor_codes');
    }
};
