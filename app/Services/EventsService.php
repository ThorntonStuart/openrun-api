<?php

namespace App\Services;

use App\Contracts\EventTypeInterface;
use App\Models\Event;

class EventsService
{
    /**
     * @var EventTypeInterface $model
     */
    protected EventTypeInterface $model;

    public function __construct(EventTypeInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Create an attached event
     *
     * @param array $data
     * @return Event
     */
    public function create(array $data)
    {
        return $this->model->createEvent($data);
    }
}