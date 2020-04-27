<?php
namespace App\Services;
use App\Exceptions\AppError;
use App\Exceptions\ExceptionModels;
use Illuminate\Http\Request;
use App\Prescription;
use Ramsey\Uuid\Uuid;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use App\User;
use App\Patient;

class DoctorServices{

    private $prescription;
    private $azure_blob_client;
    private $blob_option;
    private $user;
    private $patient;
    public function __construct(Prescription $prescription , User $user) {
        $this->prescription = $prescription;
        $this->azure_blob_client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=travelsl;AccountKey=xF0VCFJk6X3Nc+vUAz1sfraRzhj5gcg36BSurzHDOuu18YR/iEYnId/qxwyIpTksr0znuAV/F8Y4ExeGYBQtKw==;EndpointSuffix=core.windows.net');
        $this->blob_option = new CreateBlockBlobOptions();
        $this->blob_option->setContentType('image/png');
        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return Prescription
     */
    public function add_prescription(Request $request){
        $prescription_id = Uuid::uuid1()->toString();
        $this->prescription->id = $prescription_id;
        $this->prescription->comment = $request->input('comment');
        $this->prescription->image_url = 'https://travelsl.blob.core.windows.net/hms/'.$prescription_id;
        $this->prescription->patient_id = $request->input('patientId');
        $this->prescription->doctor_id = $request->user_id;
        $this->prescription->issued_date = \date('Y-m-d');
        $this->azure_blob_client->createBlockBlob('hms',$prescription_id,\base64_decode($request->input('prescription')),$this->blob_option);
        $this->prescription->save();
        return $this->prescription;
    }

    public function get_patient(Request $request){
        if(!empty($request->email) && !empty($request->password)){
            $user_by_email = $this->user->join('patient','user.id','patient.id')->where('user.email',$request->email)->where('user.role',3)->first();
            if(!empty($user_by_email)){
                if(password_verify($request->password,$user_by_email['password'])){
                    return $user_by_email;
                }else
                    throw new AppError('Password Not Match',401,ExceptionModels::LOGIN_ERROR);
            }else
                throw new AppError('There Is No User With This Email',401,ExceptionModels::LOGIN_ERROR);
        }else{
            throw new AppError('Please Fill All Fields',400,ExceptionModels::INVALIED_REQUEST);
        }
    }

    public function get_old_prescriptions(Request $request , $patient_id){
        return $this->prescription->where('patient_id',$patient_id)->where('doctor_id',$request->user_id)->get();
    }

    public function get_my_prescriptions(Request $request){
        //$offSet = (5 * $pageNo) - 5;
        return $this->prescription->select('full_name','prescription.id','patient.id as patient_id','comment','image_url')->join('patient','prescription.patient_id','patient.id')->where('prescription.doctor_id',$request->user_id)->get();
        //return $this->prescription->where('doctor_id',$request->user_id)->get();
    }
    public function delete_prescription(Request $request , $prescription_id){
        $this->azure_blob_client->deleteBlob('hms', $prescription_id);
        return $this->prescription->where('id',$prescription_id)->delete();
    }

    public function update_prescription(Request $request){
        if(!empty($request->id)){
            if(!empty($request->prescription)){
                //$this->azure_blob_client->deleteBlob('hms', $$request->id);
                $this->azure_blob_client->createBlockBlob('hms',$request->id,\base64_decode($request->input('prescription')),$this->blob_option);
                return $this->prescription->where('id',$request->id)->update([
                    'comment'=>$request->comment,
                ]);
            }else{
                return $this->prescription->where('id',$request->id)->update([
                    'comment'=>$request->comment,
                ]);
            }
        }else
            throw new AppError('Id Missing',400,ExceptionModels::INVALIED_REQUEST);
    }

    public function get_prescription_by_id(Request $request , $prescription_id){
        return $this->prescription->where('id',$prescription_id)->first();
    }
}