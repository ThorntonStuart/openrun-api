<?php

namespace App\Services;

use App\Events\Messages\MessageSent;
use App\Models\Conversation;
use App\Models\Message;

class MessagesService
{
    public function create(Conversation $conversation, array $data): Message
    {
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $data['user_id'],
            'body' => $data['message'],
        ]);

        broadcast(new MessageSent($conversation, $message))->toOthers();

        return $message;
    }
}