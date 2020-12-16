<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternalSearchService
{
    /**
     * @var int $limit
     */
    protected int $limit;

    public function __construct(int $limit = 20)
    {
        $this->limit = $limit;
    }

    public function userSearch(string $term)
    {
        $user = Auth::user();

        $results = User::where(DB::raw('concat(first_name, " ", last_name)'), 'LIKE', "%{$term}%")
            ->limit($this->limit)
            ->get()
            ->map(fn (User $user) => $this->formatUserResult($user))
            ->toArray();

        return [
            'hits' => $results
        ];
    }

    /**
     * Format a user for a search result
     *
     * @param User $user
     * @return array
     */
    protected function formatUserResult(User $user): array
    {
        return $user->toSearchableArray();
    }
}