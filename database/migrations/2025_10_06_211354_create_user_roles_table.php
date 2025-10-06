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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->uuid('model_uuid');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->string('model_type')->default('App\\Models\\User');
            $table->timestamps();
            
            $table->foreign('model_uuid')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['model_uuid', 'role_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
