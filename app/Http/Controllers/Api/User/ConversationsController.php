<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\ConversationsService;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    /**
     * @var ConversationsService $conversationsService
     */
    protected ConversationsService $conversationsService;

    public function __construct(ConversationsService $conversationsService)
    {
        $this->conversationsService = $conversationsService;
    }

    public function index(Request $request)
    {
        return $this->conversationsService->getConversations($request->user());
    }

    public function show(Conversation $conversation)
    {
        return new ConversationResource($conversation->load('participants', 'messages'));
    }
}
