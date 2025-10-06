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
        Schema::table('incident_comments', function (Blueprint $table) {
            $table->dropColumn('is_anonymous');
        });
        
        Schema::table('incident_verifications', function (Blueprint $table) {
            $table->dropColumn('is_anonymous');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incident_comments', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false);
        });
        
        Schema::table('incident_verifications', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false);
        });
    }
};
