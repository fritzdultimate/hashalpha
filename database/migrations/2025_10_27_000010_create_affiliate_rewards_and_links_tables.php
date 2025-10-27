<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void {
//         // affiliate links / codes
//         Schema::create('affiliate_links', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->cascadeOnDelete();
//             $table->string('code', 64)->unique();
//             $table->string('label')->nullable();
//             $table->json('meta')->nullable();
//             $table->timestamps();
//         });

//         // affiliate rewards ledger
//         Schema::create('affiliate_rewards', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // receiver of reward
//             $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete(); // origin of commission
//             $table->unsignedTinyInteger('level')->default(1); // 1..10
//             $table->unsignedInteger('percent_bps')->default(0); // basis points (10000 = 100%)
//             $table->unsignedBigInteger('amount')->default(0); // smallest unit
//             $table->bigInteger('amount_usd_cents')->nullable();
//             $table->foreignId('stake_id')->nullable()->constrained('stakes')->nullOnDelete();
//             $table->string('status')->default('pending'); // pending/paid/failed
//             $table->json('meta')->nullable();
//             $table->timestamp('calculated_for')->nullable(); // calculation date (day)
//             $table->timestamps();

//             $table->index(['user_id','status']);
//             $table->index(['from_user_id','calculated_for']);
//         });
//     }

//     public function down(): void {
//         Schema::dropIfExists('affiliate_rewards');
//         Schema::dropIfExists('affiliate_links');
//     }
// };
