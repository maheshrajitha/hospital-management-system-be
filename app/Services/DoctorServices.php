<?php
namespace App\Services;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use Illuminate\Http\Request;
use App\Prescription;
use Ramsey\Uuid\Uuid;
use App\User;
use App\Patient;
use App\Services\PrescriptionService;

class DoctorServices{

    private $prescription;
    private $blob_option;
    private $user;
    private $patient;
    /**
     * construct
     */
    public function __construct(Prescription $prescription , User $user , Patient $patient , PrescriptionService $prescription_service) {
        $this->prescription = $prescription_service;
        $this->user = $user;
        $this->patient = $patient;
    }

    /**
     * add prescription to patient
     * @param Request $request
     * @return Prescription
     */
    public function add_prescription(Request $request){
        return $this->prescription->add_prescription($request);
    }

    /**
     * get patient
     */
    public function get_patient(Request $request){
        if(!empty($request->id)){
            $patient_by_id = $this->patient->where('id',$request->id)->first();
            if(!empty($patient_by_id)){
                return $patient_by_id;
            }else
                throw new AppError('There Is No Patient With This ID',401,ExceptionModels::LOGIN_ERROR);
        }else{
            throw new AppError('Please Fill All Fields',400,ExceptionModels::INVALIED_REQUEST);
        }
    }


    /**
     * get old prescriptions
     */
    public function get_old_prescriptions(Request $request , $patient_id){
        return $this->prescription->get_prescription_by_patient_id($patient_id);
    }

    public function get_my_prescriptions(Request $request){
        return $this->prescription->get_prescriptions_doctor_id($request->user_id);
    }
    public function delete_prescription(Request $request , $prescription_id){
        return $this->prescription->delete_prescription($prescription_id);
    }

    public function update_prescription(Request $request){
        return $this->prescription->update_prescription($request);
    }

    public function get_prescription_by_id(Request $request , $prescription_id){
        return $this->prescription->get_prescription_by_id($prescription_id);
    }
}