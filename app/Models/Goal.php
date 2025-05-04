<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'progress',
        'visibility',
        'latitude',
        'longitude',
        'user_id',
        'parent_id',
        'image_path',
        'status',  // Ajout de la colonne 'status' ici
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'progress' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Goal::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Goal::class, 'parent_id');
    }

    public function timelineEntries(): HasMany
    {
        return $this->hasMany(TimelineEntry::class);
    }
}
