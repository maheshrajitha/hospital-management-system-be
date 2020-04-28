<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use App\Session;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Cookie;
use Firebase\JWT\JWT;
use Illuminate\Hashing\BcryptHasher;

class AuthService{

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login(Request $request){
        if(!empty($request->input("email")) and !empty($request->input("password"))){
            $user_by_email = $this->user::where('email',$request->input("email"))->first();
            if(!empty($user_by_email)){
                $hasher = new BcryptHasher(['algoName'=>'bcrypt']);
                if($hasher->check($request->password,$user_by_email['password'])){
                    $iat = new \DateTime();
                    $payload = [
                        'id'=>Uuid::uuid5(Uuid::uuid1(),'at')->toString(),
                        'user_id'=>$user_by_email['id'],
                        'role'=>$user_by_email['role'],
                        'iat'=> $iat->getTimestamp()
                    ];
                    //$session_id = Uuid::uuid5(Uuid::uuid1(),'at')->toString();
                    $user_response = new Response(array('token'=>JWT::encode($payload, env('TOKEN_KEY',null)),'user'=> $user_by_email));
                    return $user_response;
                }else
                    throw new AppError('Password Not Match',401,ExceptionModels::LOGIN_ERROR);
            }else
                throw new AppError('Email Not Match',401,ExceptionModels::LOGIN_ERROR);
        }else
            throw new AppError('Email Should Not Be Empty',400,ExceptionModels::INVALIED_REQUEST);
    }
}
