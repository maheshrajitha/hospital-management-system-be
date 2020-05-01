<?php
namespace App\Services;

use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use App\Patient;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;

class PharmacistService{
    private $patient;
    private $prescription_service;
    public function __construct(Patient $patient , PrescriptionService $prescription_service) {
        $this->patient = $patient;
        $this->prescription_service = $prescription_service;
    }
    public function get_patient_by_id(Request $request){
        if(!empty($request->id)){
            $patient = $this->patient->where('id',$request->id)->first();
            if(!empty($patient))
                return $patient;
            else
                throw new AppError('Not Fount',403,ExceptionModels::LOGIN_ERROR);
        }else
            throw new AppError('Patient ID Empty',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function get_prescription($patient_id){
        return $this->prescription_service->get_prescription_by_patient_id($patient_id);
    }
}