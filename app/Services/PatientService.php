<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Prescription;
use App\Services\PrescriptionService;
class PatientService{


    private $prescription;

    public function __construct(Prescription $prescription) {
        $this->prescription = $prescription;
    }

    public function get_my_prescription(Request $request , $page_no){
        $offSet = (5 * $page_no) - 5;
        return array("prescriptions"=>$this->prescription->where('patient_id',$request->user_id)->offset($offSet)->limit(5)->get(),'pages'=>\floor($this->prescription->count() / 5));
    }
}