<?php

namespace App\Traits;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait UsesUuid
{
    use GeneratesUuid;
    
    /**
     * Get the route key for the resource.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}