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
        Schema::create('incident_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('verification_type', ['confirm', 'dispute']);
            $table->text('comment')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('verifier_name')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('verification_source')->nullable(); // eyewitness, victim, etc.
            $table->timestamps();
            
            // Ensure one verification per user per incident
            $table->unique(['incident_id', 'user_id']);
            $table->index(['incident_id', 'verification_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_verifications');
    }
};
