<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LookupAddress extends Model
{
    use HasFactory;

    /**
     * Set the fillable attributes for the model.
     *
     * @param  array  $fillable
     * @return $this
     */
    protected $fillable = [
        'building_name',
        'street',
        'town',
        'postcode',
        'latitude',
        'longitude',
    ];

    /**
     * @return MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * @return string
     */
    public function getInlineAddressAttribute(): string
    {
        return collect([
            $this->building_name,
            $this->street,
            $this->town,
            $this->postcode,
        ])
            ->filter()
            ->unique()
            ->implode(', ');
    }

    /**
     * @return string
     */
    public function getShortAddressAttribute(): string
    {
        return collect([
            $this->building_name,
            $this->street,
            $this->town,
        ])
            ->filter()
            ->unique()
            ->implode(', ');
    }
}
