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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('category', [
                'theft_robbery',
                'sexual_harassment',
                'domestic_violence',
                'suspicious_activities',
                'traffic_accidents',
                'drugs',
                'cybercrime'
            ]);
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->integer('verification_count')->default(0);
            $table->integer('dispute_count')->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('division')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reporter_name')->nullable();
            $table->string('reporter_phone')->nullable();
            $table->string('reporter_email')->nullable();
            $table->timestamp('incident_date')->nullable();
            $table->json('metadata')->nullable(); // For additional data like weather, time of day, etc.
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['category', 'status']);
            $table->index(['latitude', 'longitude']);
            $table->index('incident_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
