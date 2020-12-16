<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_image')->singleFile();
    }

    /**
     * Get profile image url
     *
     * @return string
     */
    public function getProfileImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('profile_image') ?: asset('images/user.png');
    }
}
