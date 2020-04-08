<?php

namespace App\Services;

use App\Doctor;
use Ramsey\Uuid\Uuid;
use App\User;
use App\Services\UserService;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;

class AdminService{

    private $doctor;
    private $user_service;
    public function __construct(Doctor $doctor , UserService $user_service) {
        $this->doctor = $doctor;
        $this->user_service = $user_service;
    }

    public function add_new_doctor($request){
        if(!empty($request->input('email'))){
            $id = Uuid::uuid1()->toString();
            if(!empty($this->user_service->save_user($request , $id))){
                $this->doctor->id = $id;
                $this->doctor->email = $request->input('email');
                $this->doctor->full_name = $request->input('fullName');
                $this->doctor->tel_number = $request->input('telNumber');
                $this->doctor->gender = $request->input('gender');
                $this->doctor->specialities = $request->input('specialities');
                $this->doctor->reg_number = $request->input('regNumber');
                $this->doctor->address = $request->input('address');
                $this->doctor->save();
                return $this->doctor;
            }else
                throw new AppError('Email Already In Used',409,ExceptionModels::USER_EXISTS);
        }else
            throw new AppError('Please Fill Email Address',400,ExceptionModels::INVALIED_REQUEST);

    }

    public function get_all_doctors($page_no){
        $offSet = (5 * $page_no) - 5;
        return $this->doctor->offset($offSet)->limit(5)->get();
    }
}