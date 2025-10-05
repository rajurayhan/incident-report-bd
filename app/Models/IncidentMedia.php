<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class IncidentMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'file_path',
        'file_name',
        'file_type',
        'mime_type',
        'file_size',
        'storage_disk',
        'is_moderated',
        'moderation_reason',
        'is_sensitive',
    ];

    protected $casts = [
        'is_moderated' => 'boolean',
        'is_sensitive' => 'boolean',
    ];

    // Relationships
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    public function scopeAudio($query)
    {
        return $query->where('file_type', 'audio');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->storage_disk)->url($this->file_path);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileTypeLabelAttribute(): string
    {
        return match($this->file_type) {
            'image' => 'Image',
            'video' => 'Video',
            'audio' => 'Audio',
            default => ucfirst($this->file_type)
        };
    }
}
