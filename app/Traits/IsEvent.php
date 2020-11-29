<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait IsEvent
{
    /**
     * Create an event
     *
     * @param array $data
     * @return Model
     */
    public function createEvent(array $data)
    {
        $dataCollection = collect($data);

        return $this->event()->create([
            'title' => $dataCollection->title,
            'start_datetime' => $dataCollection->start_datetime,
            'end_datetime' => $dataCollection->end_datetime,
            'user_id' => $dataCollection->host_user_id,
        ]);
    }
}