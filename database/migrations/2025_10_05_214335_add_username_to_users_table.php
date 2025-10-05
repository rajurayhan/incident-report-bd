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
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });
        }
        
        // Generate usernames for existing users
        \DB::table('users')->whereNull('username')->get()->each(function ($user) {
            $baseUsername = strtolower(str_replace(' ', '_', $user->name));
            $username = $baseUsername;
            $counter = 1;
            
            while (\DB::table('users')->where('username', $username)->exists()) {
                $username = $baseUsername . '_' . $counter;
                $counter++;
            }
            
            \DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
