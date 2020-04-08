<?php

namespace App\Http\Middleware;

use App\Exceptions\AppError;
use Closure;
use App\Exceptions\ExceptionModels;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class RoleUser
{
    public function handle($request, Closure $next, $role)
    {
        if(!empty($request->header('Authorization'))){
            $decoded_token = JWT::decode(\str_replace('Bearer ','',$request->header('Authorization')), env('TOKEN_KEY',null), array('HS256'));
            if($decoded_token->role == $role){
                return $next($request);
            }else
                throw new AppError('You Have No Access',403,ExceptionModels::UNAUTHORIZED);
        }else
            throw new AppError('You Have No Access',403,ExceptionModels::UNAUTHORIZED);
    }
}
