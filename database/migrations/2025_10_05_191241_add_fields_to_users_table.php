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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['user', 'moderator', 'admin'])->default('user')->after('phone');
            $table->boolean('is_verified')->default(false)->after('role');
            $table->boolean('is_active')->default(true)->after('is_verified');
            $table->decimal('latitude', 10, 8)->nullable()->after('is_active');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('city')->nullable()->after('longitude');
            $table->string('district')->nullable()->after('city');
            $table->string('division')->nullable()->after('district');
            $table->integer('alert_radius_km')->default(5)->after('division');
            $table->boolean('sms_alerts_enabled')->default(false)->after('alert_radius_km');
            $table->boolean('email_alerts_enabled')->default(true)->after('sms_alerts_enabled');
            $table->boolean('push_alerts_enabled')->default(true)->after('email_alerts_enabled');
            $table->json('alert_categories')->nullable()->after('push_alerts_enabled');
            $table->timestamp('last_alert_at')->nullable()->after('alert_categories');
            $table->integer('verification_score')->default(0)->after('last_alert_at');
            $table->integer('reports_count')->default(0)->after('verification_score');
            $table->integer('comments_count')->default(0)->after('reports_count');
            $table->integer('verifications_count')->default(0)->after('comments_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'role', 'is_verified', 'is_active',
                'latitude', 'longitude', 'city', 'district', 'division',
                'alert_radius_km', 'sms_alerts_enabled', 'email_alerts_enabled',
                'push_alerts_enabled', 'alert_categories', 'last_alert_at',
                'verification_score', 'reports_count', 'comments_count', 'verifications_count'
            ]);
        });
    }
};
