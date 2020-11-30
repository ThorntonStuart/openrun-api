<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }

    public function withEvent(array $data = [])
    {
        return Event::factory($data)->for(Game::factory(), 'eventable');
    }
}
