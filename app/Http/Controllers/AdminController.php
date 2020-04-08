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
    public function add_new_doctor(Request $request)
    {
        return response()->json($this->admin_service->add_new_doctor($request),201);
    }

    public function get_all_doctors(Request $request , $page_no){
        return response()->json($this->admin_service->get_all_doctors($page_no),200);
    }
    
}
