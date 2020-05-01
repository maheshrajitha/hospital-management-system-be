<?php

namespace App\Services;

use App\Doctor;
use Ramsey\Uuid\Uuid;
use App\User;
use App\Services\UserService;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use App\Patient;
use App\Pharmacist;
use App\Staff;
use App\Prescription;

class AdminService{

    private $doctor;
    private $user_service;
    private $patient;
    private $pharmacist;
    private $staff;
    private $prescription;

    public function __construct(Doctor $doctor , UserService $user_service , Patient $patient , Pharmacist $pharmacist , Staff $staff , Prescription $prescription) {
        $this->doctor = $doctor;
        $this->user_service = $user_service;
        $this->patient = $patient;
        $this->pharmacist = $pharmacist;
        $this->staff = $staff;
        $this->prescription = $prescription;
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

    public function update_doctor($request){
        if(!empty($request->id)){
            return $this->doctor->where('id',$request->id)->update(['full_name'=>$request->fullName,'tel_number'=>$request->telNumber,'specialities'=>$request->specialities,'reg_number'=>$request->regNumber,'address'=>$request->address]);
        }else throw new AppError('Id Missing',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function get_all_doctors($page_no){
        $offSet = (5 * $page_no) - 5;
        return array('doctorList'=>$this->doctor->offset($offSet)->limit(5)->get() , 'pages'=> \floor($this->doctor->count() / 5));
    }

    public function delete($request ,$role, $doctor_id){
        if($this->user_service->delete_user($request,$doctor_id)){
            if($role == 2)
                return $this->doctor->where('id',$doctor_id)->delete();
            elseif($role == 3){
                $this->prescription->where('patient_id',$doctor_id)->delete();
                return $this->patient->where('id',$doctor_id)->delete();
            }
            elseif($role == 4)
                return $this->pharmacist->where('id',$doctor_id)->delete();
	        elseif($role == 5)
                return $this->staff->where('id',$doctor_id)->delete();
            else
            return false;
        }
        return false;
    }

    public function get_all_doctor_table_count($request){
        $doctor_table_count = $this->doctor->count();
        return $doctor_table_count;
    }

    public function add_new_patient($request){
        if(!empty($request->input('email')) && !empty($request->input('fullName'))){
            $patient_id = \substr(\uniqid(),0,12);
            if(!empty($this->user_service->save_user($request , $patient_id))){
                $this->patient->id = $patient_id;
                $this->patient->full_name = $request->input('fullName');
                $this->patient->email = $request->input('email');
                $this->patient->dob = $request->input('dob');
                $this->patient->gender = $request->input('gender');
                $this->patient->tel_number = $request->input('telNumber');
                $this->patient->nic = $request->input('nic');
                $this->patient->address = $request->input('address');
                $this->patient->save();
                return $this->patient;
            }else
                throw new AppError('This User Exists',409,ExceptionModels::USER_EXISTS);
        }else
            throw new AppError('Please Fill Required Fields',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function update_patient($request){
        if(!empty($request->id)) return $this->patient->where('id',$request->id)->update(['full_name'=>$request->fullName,'tel_number'=>$request->telNumber,'nic'=>$request->nic,'address'=>$request->address]);
        else throw new AppError('Id Missing',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function get_patients($request , $page_no){
        $offSet = (5 * $page_no) - 5;
        return array("patients"=>$this->patient->offset($offSet)->limit(5)->get(),'pages'=>\floor($this->patient->count() / 5));
    }

    public function addNewPharmacist($request){
        if(!empty($request->input('email')) && !empty($request->input('fullName'))){
            $pharmacistId = Uuid::uuid1()->toString();
            if(!empty($this->user_service->save_user($request,$pharmacistId))){
                $this->pharmacist->id = $pharmacistId;
                $this->pharmacist->full_name = $request->input('fullName');
                $this->pharmacist->email = $request->input('email');
                $this->pharmacist->dob = $request->input('dob');
                $this->pharmacist->gender = $request->input('gender');
                $this->pharmacist->tel_number = $request->input('telNumber');
                $this->pharmacist->address = $request->input('address');
                $this->pharmacist->save();
                return $this->pharmacist;
            }else
                throw new AppError('This User Exists',409,ExceptionModels::USER_EXISTS);
        }else
            throw new AppError('Please Fill Required Fields',400,ExceptionModels::INVALIED_REQUEST);
    }
    public function update_pharmacist($request){
        if (!empty($request->id))
            return $this->pharmacist->where('id',$request->id)->update(
                [
                    'full_name'=>$request->fullName,
                    'tel_number'=>$request->telNumber,
                    'address'=>$request->address
                ]
            );
        else throw new AppError('Id Missing',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function getPharmacists($request , $pageNo){
        $offSet = (5 * $pageNo) - 5;
        return array("pharmacists"=>$this->pharmacist->offset($offSet)->limit(5)->get(),'pages'=>\floor($this->pharmacist->count() / 5));
    }

    public function addNewStaffMember($request){
        if(!empty($request->input('email')) && $request->input('fullName')){
            $staffMemberId = Uuid::uuid1()->toString();
            if(!empty($this->user_service->save_user($request , $staffMemberId))){
                $this->staff->id = $staffMemberId;
                $this->staff->full_name = $request->input('fullName');
                $this->staff->email = $request->input('email');
                $this->staff->dob = $request->input('dob');
                $this->staff->job_role = $request->input('jobRole');
                $this->staff->gender = $request->input('gender');
                $this->staff->tel_number = $request->input('telNumber');
                $this->staff->address = $request->input('address');
                $this->staff->save();
                return $this->staff;
            }else
                throw new AppError('This User Exists',409,ExceptionModels::USER_EXISTS);
        }else
            throw new AppError('Please Fill Required Fields',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function update_staff_member($request){
        if(!empty($request->id))
            return $this->staff->where('id',$request->id)->update(
                [
                    'full_name'=>$request->fullName,
                    'job_role'=>$request->jobRole,
                    'tel_number'=>$request->telNumber,
                    'address'=>$request->address
                ]
            );
        else throw new AppError('ID Missing',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function getStaffMembers($request , $pageNo){
        $offSet = (5 * $pageNo) - 5;
        return array("members"=>$this->staff->offset($offSet)->limit(5)->get(),'pages'=>\floor($this->staff->count() / 5));
    }

    public function get_by_role_and_id($request , $role , $id){
        if($role == 2){
            return $this->doctor->where('id',$id)->first();
        }elseif($role == 3)
            return $this->patient->where('id',$id)->first();
        elseif($role == 4)
            return $this->pharmacist->where('id',$id)->first();
        elseif($role == 5)
            return $this->staff->where('id',$id)->first();
        else
            throw new AppError('User Not Found',404,ExceptionModels::NOT_FOUND);
    }
}
