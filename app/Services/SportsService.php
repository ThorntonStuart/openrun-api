<?php

namespace App\Services;

use App\Models\Sport;

class SportsService
{
    public function create(array $data)
    {
        return Sport::create([
            'name' => $data['name'],
        ]);
    }
}