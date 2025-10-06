<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\PasswordResetNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        'is_verified',
        'is_active',
        'latitude',
        'longitude',
        'city',
        'district',
        'division',
        'alert_radius_km',
        'sms_alerts_enabled',
        'email_alerts_enabled',
        'push_alerts_enabled',
        'alert_categories',
        'last_alert_at',
        'verification_score',
        'reports_count',
        'comments_count',
        'verifications_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'sms_alerts_enabled' => 'boolean',
            'email_alerts_enabled' => 'boolean',
            'push_alerts_enabled' => 'boolean',
            'alert_categories' => 'array',
            'last_alert_at' => 'datetime',
        ];
    }

    // Relationships
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IncidentComment::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(IncidentVerification::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(UserAlert::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeNearby($query, $latitude, $longitude, $radiusKm = 5)
    {
        return $query->selectRaw('*, 
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
            [$latitude, $longitude, $latitude])
            ->having('distance', '<=', $radiusKm)
            ->orderBy('distance');
    }

    // Accessors & Mutators
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'user' => 'User',
            'moderator' => 'Moderator',
            'admin' => 'Administrator',
            default => ucfirst($this->role)
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['moderator', 'admin']);
    }

    public function canReceiveAlerts(): bool
    {
        return $this->is_active && (
            $this->sms_alerts_enabled || 
            $this->email_alerts_enabled || 
            $this->push_alerts_enabled
        );
    }

    /**
     * Check if user has verified email (temporarily disabled)
     */
    public function hasVerifiedEmail(): bool
    {
        return true; // Always return true for now
    }

    /**
     * Check if user can perform actions that require email verification
     */
    public function canPerformVerifiedActions(): bool
    {
        return true; // Always return true for now
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
}
