<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;

class PatientController extends Controller{
    private $patient_service;
    public function __construct(PatientService $patient_service) {
        $this->patient_service = $patient_service;
    }

    public function get_my_prescriptions(Request $request , $patient_id){
        return \response()->json($this->patient_service->get_my_prescription($request , $patient_id));
    }
}