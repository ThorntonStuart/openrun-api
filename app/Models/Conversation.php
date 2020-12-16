<?php

namespace App\Models;

use App\Models\Traits\RetrievesTableName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends BaseModel
{
    use HasFactory, RetrievesTableName;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'subject',
    ];

    /**
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'conversation_participants',
            'conversation_id',
            'user_id'
        );
    }

    /**
     * Get all conversations linked to a user
     *
     * @param Builder $query
     * @param integer $userId
     * @return void
     */
    public function scopeForUser(Builder $query, int $userId)
    {
        return Conversation::whereHas('participants', function (Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
}
