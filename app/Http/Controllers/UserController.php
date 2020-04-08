<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private $user_service;
    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }
    public function save_user(Request $request)
    {
        return response()->json($this->user_service->save_user($request),201);
    }
    
}
