<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use App\Services\SportsService;
use App\Services\UsersService;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * @var UsersService $usersService
     */
    protected UsersService $usersService;

    public function __construct(
        UsersService $usersService,
        SportsService $sportsService
    )
    {
        $this->usersService = $usersService;
        $this->sportsService = $sportsService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sportBasketball = $this->sportsService->create(['name' => 'Basketball']);
        $sportNetball = $this->sportsService->create(['name' => 'Netball']);

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
