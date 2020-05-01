<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PharmacistService;

class PharmacistController extends Controller{

    private $pharmacist_service;
    public function __construct(PharmacistService $pharmacist_service) {
        $this->pharmacist_service = $pharmacist_service;
    }

    public function get_patient_by_id(Request $request){
        return \response()->json($this->pharmacist_service->get_patient_by_id($request));
    }

    public function get_prescriptions(Request $request , $patient_id){
        return \response()->json($this->pharmacist_service->get_prescription($patient_id));
    }
}