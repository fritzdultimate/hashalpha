<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 18, 8);
            $table->enum('type', ['credit', 'debit']);
            $table->string('reason')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('admin_transactions');
    }
};
