<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class UpcomingEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = $request->user()->eventsAttending
            ->load(['participants', 'sport'])
            ->sortBy('start_datetime');
        
        return EventResource::collection($events);
    }
}
