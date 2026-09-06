<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('compounding_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // The matured stake this offer was generated from.
            $table->foreignId('stake_id')->constrained('stakes')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('staking_plans');
            // The stake created once the user accepts (null until then).
            $table->foreignId('new_stake_id')->nullable()->constrained('stakes')->nullOnDelete();

            // Terms snapshotted from the plan at offer time, per the user's request
            // that they come from the matured stake's own plan, not admin-typed
            // values -- so a later edit to the plan doesn't retroactively change an
            // offer that's already out.
            $table->decimal('min_roi', 5, 2);
            $table->decimal('max_roi', 5, 2);
            $table->unsignedInteger('duration_days');

            $table->string('status')->default('offered'); // offered|accepted|declined|expired
            $table->boolean('notify_daily')->default(false);

            $table->timestamp('offered_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('responded_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('compounding_offers');
    }
};
