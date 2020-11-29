<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait UsesUuid
{
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'uuid')) {
                if (!$model->uuid) {
                    $model->uuid = (string) Str::uuid();
                }
            }
        });
    }
}