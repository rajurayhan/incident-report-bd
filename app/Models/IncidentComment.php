<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'user_id',
        'content',
        'is_anonymous',
        'commenter_name',
        'likes_count',
        'dislikes_count',
        'is_moderated',
        'moderation_reason',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_moderated' => 'boolean',
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
    public function scopeNotModerated($query)
    {
        return $query->where('is_moderated', false);
    }

    public function scopeModerated($query)
    {
        return $query->where('is_moderated', true);
    }

    public function scopeByIncident($query, $incidentId)
    {
        return $query->where('incident_id', $incidentId);
    }

    // Accessors
    public function getCommenterDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return $this->commenter_name ?? 'Anonymous';
        }
        
        return $this->user ? $this->user->name : 'Unknown User';
    }
}
