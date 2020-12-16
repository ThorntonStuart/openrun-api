<?php

namespace App\Services;

use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ConversationsService
{
    /**
     * Find conversations
     *
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function getConversations(User $user): AnonymousResourceCollection
    {
        $conversations = Conversation::forUser($user->id)
            ->with([
                'participants',
                'participants.user',
                'participants.user.profile',
            ])
            ->get();

        return ConversationResource::collection($conversations);
    }

    /**
     * Find first conversation or create one
     *
     * @param array $data
     * @return Conversation
     */
    public function firstOrCreate(array $data = []): Conversation
    {
        $conversation = Conversation::where('uuid', $data['conversation_uuid'])
            ->firstOr(function () use ($data) {
                $conversation = Conversation::create([
                    'subject' => $data['subject'] ?? null,
                ]);
                
                if (Arr::has($data, 'recipients')) {
                    $conversation = $this->createConversationParticipants($conversation, Arr::get($data, 'recipients'));
                }

                return $conversation;
            });

        return $conversation;
    }

    protected function createConversationParticipants(Conversation $conversation, $participants)
    {
        $userIds = is_array($participants) ? $participants : (array) $participants;

        return tap($conversation, function($conversation) use ($userIds) {
            collect($userIds)->each(function ($userId) use ($conversation) {
                $conversation->participants()->create(['user_id' => $userId]);
            });

            $conversation->participants()->create(['user_id' => Auth::id()]);
        });
    }
}