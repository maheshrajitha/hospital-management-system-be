<?php

namespace App\Services;

use App\Exceptions\ExceptionModels;
use App\User;
use Ramsey\Uuid\Uuid;
use App\Exceptions\AppError;

class UserService
{

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function save_user($request , $id=null)
    {
        if(!empty($request->input('email'))){
            if(empty($this->get_user_by_email($request->input('email')))){
                $this->user->id = ($id === null)? Uuid::uuid1()->toString() : $id;
                $this->user->email = $request->input('email');
                $this->user->user_name = empty($request->input('username'))?'Jhone Doe':$request->input('username');
                $this->user->password = empty($request->input('password')) ? password_hash('1234',PASSWORD_BCRYPT) :password_hash($request->input('password'),PASSWORD_BCRYPT);
                $this->user->role = $request->input('role');
                $this->user->save();
                return $this->user;;
            }else
                throw new AppError('This Email Already In Use',409,ExceptionModels::USER_EXISTS);
        }else
            throw new AppError('Please Fill Email',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function get_user_by_email($email){
        return User::where('email',$email)->first();
    }
    
    public function delete_user($request , $user_id){
        return $this->user->where('id',$user_id)->delete();
    }
}
