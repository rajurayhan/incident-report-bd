<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'user_id',
        'verification_type',
        'comment',
        'is_anonymous',
        'verifier_name',
        'latitude',
        'longitude',
        'verification_source',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeConfirmations($query)
    {
        return $query->where('verification_type', 'confirm');
    }

    public function scopeDisputes($query)
    {
        return $query->where('verification_type', 'dispute');
    }

    public function scopeByIncident($query, $incidentId)
    {
        return $query->where('incident_id', $incidentId);
    }

    // Accessors
    public function getVerifierDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return $this->verifier_name ?? 'Anonymous';
        }
        
        return $this->user ? $this->user->name : 'Unknown User';
    }

    public function getVerificationTypeLabelAttribute(): string
    {
        return match($this->verification_type) {
            'confirm' => 'Confirmed',
            'dispute' => 'Disputed',
            default => ucfirst($this->verification_type)
        };
    }
}
