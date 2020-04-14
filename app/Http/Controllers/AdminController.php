<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Cookie;
class AdminController extends Controller
{
    private $admin_service;
    public function __construct(AdminService $admin_service) {
        $this->admin_service = $admin_service;
    }
    public function add_new_doctor(Request $request){
        return response()->json($this->admin_service->add_new_doctor($request),201);
    }

    public function get_all_doctors(Request $request , $page_no){
        return response()->json($this->admin_service->get_all_doctors($page_no),200);
    }
    
    public function delete(Request $request ,$role, $doctor_id){
        return response()->json($this->admin_service->delete($request ,$role, $doctor_id));
    }

    public function get_doctor_table_size(Request $request){
        return response()->json(['tableSize'=>$this->admin_service->get_all_doctor_table_count($request)],200);
    }

    public function add_new_patient(Request $request){
        return response()->json($this->admin_service->add_new_patient($request),201);
    }

    public function get_all_patients(Request $request , $page_no){
        return response()->json($this->admin_service->get_patients($request , $page_no),200);
    }

    public function addNewPharmacist(Request $request){
        return \response()->json($this->admin_service->addNewPharmacist($request),201);
    }

    public function getAllPharmacists(Request $request , $page_no){
        return response()->json($this->admin_service->getPharmacists($request , $page_no),200);
    }

    public function addNewStaffMember(Request $request){
        return \response()->json($this->admin_service->addNewStaffMember($request),201);
    }

    public function getStaffMembers(Request $request , $page_no){
        return response()->json($this->admin_service->getStaffMembers($request , $page_no),200);
    }
}
