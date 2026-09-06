<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('enhanced_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Supporting documents the user submits for the extra due-diligence
            // tier (source-of-funds proof, etc.) -- stored the same way KYC
            // documents already are (local disk, not a third party).
            $table->string('proof_of_funds_document');
            $table->string('additional_document')->nullable();
            $table->text('notes')->nullable(); // user's own note, e.g. source of funds

            $table->string('status')->default('pending'); // pending|approved|rejected
            $table->text('admin_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();

            // Internal reference issued by us on approval -- not a third-party
            // certificate, just an auditable record admin can point back to.
            $table->string('certificate_number')->nullable()->unique();
            $table->timestamp('certificate_issued_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('enhanced_verifications');
    }
};
