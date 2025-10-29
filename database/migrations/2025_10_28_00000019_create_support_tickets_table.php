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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->string('type')->default('general'); // general | kyc | technical | billing | security
            $table->string('priority')->default('normal'); // low | normal | high | critical
            $table->string('status')->default('open'); // open | pending | resolved | closed
            $table->string('platform')->nullable(); // web | android | ios
            $table->json('meta')->nullable(); // device/browser info, steps, etc
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
