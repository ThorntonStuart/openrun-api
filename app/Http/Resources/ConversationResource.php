<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
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
            'subject' => $this->subject,
            'participants' => ConversationParticipantResource::collection(
                $this->whenLoaded('participants')
            ),
            'messages' => MessageResource::collection(
                $this->whenLoaded('messages')
            ),
        ];
    }
}
