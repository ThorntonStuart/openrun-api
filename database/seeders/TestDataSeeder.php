<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use App\Services\UsersService;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * @var UsersService $usersService
     */
    protected UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game = Game::factory()->withEvent()->create();

        $user = $this->usersService->createUser([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
        ]);
        
        $user->eventsAttending()->attach($game);
    }
}
