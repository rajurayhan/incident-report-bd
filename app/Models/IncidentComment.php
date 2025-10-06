<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncidentComment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'incident_id',
        'parent_id',
        'user_id',
        'content',
        'mentioned_users',
        'commenter_name',
        'likes_count',
        'dislikes_count',
        'is_moderated',
        'moderation_reason',
    ];

    protected $casts = [
        'is_moderated' => 'boolean',
        'mentioned_users' => 'array',
    ];

    protected $appends = ['commenter_display_name'];

    // Relationships
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(IncidentComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(IncidentComment::class, 'parent_id');
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
        return $this->user ? $this->user->name : 'Unknown User';
    }
}
