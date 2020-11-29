<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Game extends Model
{
    use HasFactory;

    /**
     * @return MorphOne
     */
    public function event(): MorphOne
    {
        return $this->morphOne(Event::class, 'eventable');
    }
}
