<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Test Event #' . rand(0, 500),
            'user_id' => User::factory(),
            'start_datetime' => now()->addHour(),
            'end_datetime' => now()->addHours(3),
            'maximum_participants' => rand(10, 15),
        ];
    }
}
