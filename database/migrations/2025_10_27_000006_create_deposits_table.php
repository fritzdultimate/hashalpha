<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void {
//         Schema::create('deposits', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
//             $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
//             $table->unsignedBigInteger('amount')->default(0); // smallest unit
//             $table->bigInteger('amount_usd_cents')->nullable();
//             $table->string('address')->nullable(); // deposit address shown to user (if generated)
//             $table->string('tx_hash')->nullable()->index();
//             $table->unsignedInteger('confirmations')->default(0);
//             $table->string('status')->default('pending'); // pending, confirmed, failed, cancelled
//             $table->json('meta')->nullable(); // provider webhook payload, invoice id, etc.
//             $table->timestamp('received_at')->nullable();
//             $table->timestamp('confirmed_at')->nullable();
//             $table->timestamps();

//             $table->index(['user_id','status']);
//         });
//     }

//     public function down(): void {
//         Schema::dropIfExists('deposits');
//     }
// };
