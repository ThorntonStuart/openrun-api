<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\UsersService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param UsersService $usersService
     */
    public UsersService $usersService;
    
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function login(UserLoginRequest $request)
    {
        return $this->usersService->authenticateUser($request->input());
    }
}
