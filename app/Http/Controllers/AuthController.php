<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\Interfaces\AuthServiceInterface;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRequest $request)
    {
        return $this->authService->register($request->validated());
    }
    
    public function login()
    {
        $credentials = request(['email', 'password']);
        return $this->authService->login($credentials);
    }

    public function me()
    {
        return $this->authService->me();
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function refresh()
    {
        return $this->authService->refresh();
    }
}

