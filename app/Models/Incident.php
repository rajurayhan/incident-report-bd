<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'priority',
        'is_anonymous',
        'is_verified',
        'verification_count',
        'dispute_count',
        'latitude',
        'longitude',
        'address',
        'city',
        'district',
        'division',
        'user_id',
        'reporter_name',
        'reporter_phone',
        'reporter_email',
        'incident_date',
        'metadata',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_verified' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'incident_date' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IncidentComment::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(IncidentVerification::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(IncidentMedia::class);
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

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
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
    public function getCategoryLabelAttribute(): string
    {
        // Return the category key for frontend localization
        return $this->category;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            default => ucfirst($this->status)
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
            default => ucfirst($this->priority)
        };
    }

    public function getVerificationRatioAttribute(): float
    {
        $total = $this->verification_count + $this->dispute_count;
        return $total > 0 ? ($this->verification_count / $total) * 100 : 0;
    }
}
