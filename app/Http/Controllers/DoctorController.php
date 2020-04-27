<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DoctorServices;

class DoctorController extends Controller{

    private $doctor_servces;
    public function __construct(DoctorServices $doctor_servces) {
        $this->doctor_servces = $doctor_servces;
    }

    public function add_prescription(Request $request){
        return \response()->json($this->doctor_servces->add_prescription($request),200);
    }

    public function get_patient_by_email(Request $request){
        return response()->json($this->doctor_servces->get_patient($request),200);
    }

    public function get_old_prescription(Request $request  , $patient_id){
        return response()->json($this->doctor_servces->get_old_prescriptions($request,$patient_id),200);
    }

    public function get_prescriptions(Request $request){
        return response()->json($this->doctor_servces->get_my_prescriptions($request),200);
    }

    public function delete_prescription(Request $request , $prescription_id){
        return response()->json($this->doctor_servces->delete_prescription($request,$prescription_id),200);
    }

    public function update_prescription(Request $request){
        return response()->json($this->doctor_servces->update_prescription($request),200);
    }

    public function get_prescription_by_id(Request $request , $prescription_id){
        return \response()->json($this->doctor_servces->get_prescription_by_id($request,$prescription_id),200);
    }
}
