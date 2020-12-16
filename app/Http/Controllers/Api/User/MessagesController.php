<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\ConversationsService;
use App\Services\MessagesService;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * @var MessagesService $messagesService
     */
    protected MessagesService $messagesService;

    /**
     * @var ConversationsService $conversationsService
     */
    protected ConversationsService $conversationsService;

    public function __construct(
        ConversationsService $conversationsService,
        MessagesService $messagesService
    ) {
        $this->conversationsService = $conversationsService;
        $this->messagesService = $messagesService;
    }

    public function store(StoreMessageRequest $request)
    {
        $conversation = $this->conversationsService->firstOrCreate($request->only([
            'conversation_uuid',
            'subject',
            'recipients',
        ]));

        $this->messagesService->create($conversation, [
            'message' => $request->input('message'),
            'user_id' => $request->user()->id,
        ]);

        return new ConversationResource($conversation->load('messages', 'participants'));
    }
}
