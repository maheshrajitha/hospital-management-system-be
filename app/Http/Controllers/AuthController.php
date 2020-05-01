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

    public function validate_token(Request $request){
        return \response()->json($this->auth_service->validate_token($request));
    }
    
}
