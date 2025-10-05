<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'incident_id',
        'phone_number',
        'email',
        'alert_type',
        'status',
        'message',
        'sent_at',
        'error_message',
        'latitude',
        'longitude',
        'radius_km',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'sent_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('alert_type', $type);
    }

    public function scopeSms($query)
    {
        return $query->where('alert_type', 'sms');
    }

    public function scopeEmail($query)
    {
        return $query->where('alert_type', 'email');
    }

    public function scopePush($query)
    {
        return $query->where('alert_type', 'push');
    }

    // Accessors
    public function getAlertTypeLabelAttribute(): string
    {
        return match($this->alert_type) {
            'sms' => 'SMS',
            'email' => 'Email',
            'push' => 'Push Notification',
            default => ucfirst($this->alert_type)
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'sent' => 'Sent',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            default => ucfirst($this->status)
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'sent' => 'blue',
            'delivered' => 'green',
            'failed' => 'red',
            default => 'gray'
        };
    }
}
