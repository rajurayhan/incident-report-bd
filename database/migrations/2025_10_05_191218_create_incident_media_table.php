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
        Schema::create('incident_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('incident_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type'); // image, video, audio
            $table->string('mime_type');
            $table->bigInteger('file_size');
            $table->string('storage_disk')->default('public');
            $table->boolean('is_moderated')->default(false);
            $table->text('moderation_reason')->nullable();
            $table->boolean('is_sensitive')->default(false);
            $table->timestamps();
            
            $table->index(['incident_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_media');
    }
};
