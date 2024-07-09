<?php 

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function me();
    public function logout();
    public function refresh();
}

