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
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'is_anonymous',
                'reporter_name',
                'reporter_phone',
                'reporter_email'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false);
            $table->string('reporter_name')->nullable();
            $table->string('reporter_phone')->nullable();
            $table->string('reporter_email')->nullable();
        });
    }
};
