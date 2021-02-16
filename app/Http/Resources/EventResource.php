<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'event';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'eventable_type' => $this->eventable_type,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'maximum_participants' => $this->maximum_participants,
            'price' => $this->price_gbp,
            'host' => (new UserResource($this->whenLoaded('host'))),
            'participants' => UserResource::collection($this->whenLoaded('participants')),
            'sport' => (new SportResource($this->whenLoaded('sport'))),
        ];
    }
}
