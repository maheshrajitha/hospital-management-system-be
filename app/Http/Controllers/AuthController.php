<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $auth_service;
    public function __construct(AuthService $auth_service) {
        $this->auth_service = $auth_service;
    }
    public function login(Request $request)
    {
        return $this->auth_service->login($request);
    }
    
}
