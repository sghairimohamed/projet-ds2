<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'mood',
        'image_path',
        'user_id'
    ];

    protected $casts = [
        'mood' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 