<?php
namespace App\Services;
use App\Prescription;
use Ramsey\Uuid\Uuid;
use App\Util\AzureBlobClient;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use Illuminate\Http\Request;


class PrescriptionService{
    private $prescription;
    private $azure_blob_client;
    public function __construct(Prescription $prescription , AzureBlobClient $azure_blob_client) {
        $this->prescription = $prescription;
        $this->azure_blob_client = $azure_blob_client;
    }

    public function get_prescriptions($page_no){
        $offSet = (5 * $page_no) - 5;
        return array("patients"=>$this->prescription->offset($offSet)->limit(5)->get(),'pages'=>\floor($this->prescription->count() / 5));
    }

    public function get_prescription_by_patient_id($patient_id){
        return $this->prescription->where('patient_id',$patient_id)->get();
    }
    public function get_prescriptions_doctor_id($doctor_id){
        //$offSet = (5 * $pageNo) - 5;
        return $this->prescription->select('full_name','prescription.id','patient.id as patient_id','comment','image_url','prescription')->join('patient','prescription.patient_id','patient.id')->where('prescription.doctor_id',$doctor_id)->get();
        //return $this->prescription->where('doctor_id',$request->user_id)->get();
    }

    public function add_prescription(Request $request){
        $prescription_id = Uuid::uuid1()->toString();
        $this->prescription->id = $prescription_id;
        $this->prescription->comment = $request->input('comment');
        $this->prescription->image_url = 'https://travelsl.blob.core.windows.net/hms/'.$prescription_id;
        $this->prescription->patient_id = $request->input('patientId');
        $this->prescription->doctor_id = $request->user_id;
        $this->prescription->issued_date = \date('Y-m-d');
        $this->prescription->prescription = $request->prescriptionDetails;
        $this->azure_blob_client->upload_image($request->prescription , $prescription_id);
        $this->prescription->save();
        return $this->prescription;
    }
    public function update_prescription(Request $request){
        if(!empty($request->id)){
            if(!empty($request->prescription)){
                //$this->azure_blob_client->deleteBlob('hms', $$request->id);
                $this->azure_blob_client->upload_image($request->input('prescription'),$request->id);
                return $this->prescription->where('id',$request->id)->update([
                    'comment'=>$request->comment,
                    'prescription'=>$request->prescriptionDetails
                ]);
            }else{
                return $this->prescription->where('id',$request->id)->update([
                    'comment'=>$request->comment,
                    'prescription'=>$request->prescriptionDetails
                ]);
            }
        }else
            throw new AppError('ID Empty',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function delete_prescription($prescription_id){
        $this->azure_blob_client->delete_image($prescription_id);
        return $this->prescription->where('id',$prescription_id)->delete();
    }

    public function get_prescription_by_id($prescription_id){
        return $this->prescription->where('id',$prescription_id)->first();
    }
}
