<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mark all existing users as verified since email verification is temporarily disabled
        DB::table('users')
            ->whereNull('email_verified_at')
            ->update([
                'email_verified_at' => now(),
                'is_verified' => true,
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert verification status (optional - only if you want to re-enable email verification later)
        DB::table('users')
            ->where('is_verified', true)
            ->update([
                'email_verified_at' => null,
                'is_verified' => false,
                'updated_at' => now()
            ]);
    }
};
