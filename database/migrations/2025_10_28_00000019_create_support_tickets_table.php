<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->enum('type', ['general', 'kyc', 'technical', 'billing', 'security'])->default('general');
            $table->enum('priority', ['normal', 'low', 'hight', 'critical'])->default('normal');
            $table->enum('status', ['open', 'pending', 'resolved', 'closed'])->default('open');
            $table->enum('platform', ['web', 'android', 'ios'])->nullable();
            $table->json('meta')->nullable(); // device/browser info, steps, etc
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('support_tickets');
    }
};
