<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Event extends Model
{
    use HasFactory, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'eventable_id',
        'eventable_type',
        'title',
        'start_datetime',
        'end_datetime',
        'price',
        'maximum_participants',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_datetime',
        'end_datetime',
    ];

    /**
     * @return MorphTo
     */
    public function eventable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }
    
    /**
     * @return BelongsTo
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
    
    /**
     * Fetch price formatted for GBP currency
     *
     * @return float
     */
    public function getPriceGbpAttribute(): float
    {
        return number_format($this->price / 100, 2);
    }
}
