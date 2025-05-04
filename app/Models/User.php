<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the goals for the user.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the badges for the user.
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withTimestamps();
    }

    /**
     * Get the shared goals for the user.
     */
    public function sharedGoals(): BelongsToMany
    {
        return $this->belongsToMany(SharedGoal::class, 'shared_goal_participants')
            ->withPivot('joined_at', 'status')
            ->withTimestamps();
    }

    /**
     * Get the progress journals for the user.
     */
    public function progressJournals(): HasMany
    {
        return $this->hasMany(ProgressJournal::class);
    }

    /**
     * Get the timeline entries for the user.
     */
    public function timelineEntries(): HasMany
    {
        return $this->hasMany(TimelineEntry::class);
    }
}
