<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void {
//         Schema::create('payouts', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->cascadeOnDelete();
//             $table->foreignId('stake_id')->nullable()->constrained('stakes')->nullOnDelete();
//             $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
//             $table->unsignedBigInteger('amount')->default(0); // smallest unit
//             $table->unsignedBigInteger('fee')->default(0); // smallest unit (fee applied)
//             $table->bigInteger('amount_usd_cents')->nullable();
//             $table->string('to_address')->nullable();
//             $table->string('tx_hash')->nullable()->index();
//             $table->string('status')->default('pending'); // pending, processing, sent, failed, cancelled
//             $table->json('meta')->nullable();
//             $table->timestamp('processed_at')->nullable();
//             $table->timestamps();

//             $table->index(['user_id','status']);
//         });
//     }

//     public function down(): void {
//         Schema::dropIfExists('payouts');
//     }
// };
