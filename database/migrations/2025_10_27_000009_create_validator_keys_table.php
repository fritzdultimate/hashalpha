<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void {
//         Schema::create('validator_keys', function (Blueprint $table) {
//             $table->id();
//             $table->string('public_key')->unique();
//             $table->unsignedInteger('validator_index')->nullable()->index();
//             $table->string('label')->nullable();
//             $table->unsignedBigInteger('total_eth_staked')->default(0); // wei
//             $table->decimal('apr', 8, 4)->nullable();
//             $table->string('status')->default('active'); // active, pending, offline, slashed
//             $table->json('meta')->nullable(); // raw API payload
//             $table->timestamp('last_reported_at')->nullable();
//             $table->timestamps();
//         });
//     }

//     public function down(): void {
//         Schema::dropIfExists('validator_keys');
//     }
// };
