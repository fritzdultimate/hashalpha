<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     public function up(): void {
//         Schema::create('user_wallets', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained()->cascadeOnDelete();
//             $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
//             $table->string('address')->index();
//             $table->string('derivation_path')->nullable();
//             $table->string('label')->nullable();
//             $table->unsignedBigInteger('onchain_balance')->default(0); // smallest unit (wei/sats)
//             $table->timestamp('last_synced_at')->nullable();
//             $table->json('meta')->nullable(); // provider id, deposit address status, etc.
//             $table->timestamps();

//             $table->unique(['user_id','coin_id','address'], 'user_coin_address_unique');
//         });
//     }

//     public function down(): void {
//         Schema::dropIfExists('user_wallets');
//     }
// };
