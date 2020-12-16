<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Services\InternalSearchService;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = (new InternalSearchService())->userSearch($request->input('search'));

        return response()->json($data);
    }
}
