<?php
use Illuminate\Http\Request;


$router->get('/', function () use ($router) {
    return 'ExampleController@index';
});

$router->group(['prefix' => 'user'],function() use ($router){
    $router->post('/',['uses'=> 'UserController@save_user']);
});

$router->group(['prefix'=>'admin','middleware'=>'role_user:1'],function() use ($router){
    $router->get('/all-doctors/{page_no}',['uses'=>'AdminController@get_all_doctors']);
    $router->post('/add-new-doctor',['uses'=>'AdminController@add_new_doctor']);
    $router->delete('/delete/{role}/{doctor_id}',['uses'=>'AdminController@delete']);
    $router->get('/get-role-and-id/{role}/{id}',['uses'=>'AdminController@get_by_role_and_id']);
    $router->post('/add-new-patient',['uses'=>'AdminController@add_new_patient']);
    $router->get('/get-all-patients/{page_no}',['uses'=>'AdminController@get_all_patients']);
    $router->post('/add-new-pharmacist',['uses'=>'AdminController@addNewPharmacist']);
    $router->get('/all-pharmacists/{page_no}',['uses'=>'AdminController@getAllPharmacists']);
    $router->post('/add-new-staff-member',['uses'=>'AdminController@addNewStaffMember']);
    $router->get('/get-staff-members/{page_no}',['uses'=>'AdminController@getStaffMembers']);
    $router->patch('/update-doctor',['uses'=>'AdminController@update_doctor']);
    $router->patch('/update-patient',['uses'=>'AdminController@update_patient']);
    $router->patch('/update-pharmacist',['uses'=>'AdminController@update_pharmacist']);
    $router->patch('/update-staff-member',['uses'=>'AdminController@update_staff_member']);
});

$router->group(['prefix'=>'doctor','middleware'=>'role_user:2'],function() use ($router){
    $router->post('/prescription',['uses'=>'DoctorController@add_prescription']);
    $router->post('/get-patient-by-email',['uses'=>'DoctorController@get_patient_by_email']);
    $router->get('/old-prescription/{patient_id}',['uses'=>'DoctorController@get_old_prescription']);
    $router->get('/my-prescriptions',['uses'=>'DoctorController@get_prescriptions']);
    $router->delete('/delete-prescription/{prescription_id}',['uses'=>'DoctorController@delete_prescription']);
    $router->patch('/update-prescription',['uses'=>'DoctorController@update_prescription']);
    $router->get('/get-prescription-by-id/{prescription_id}',['uses'=>'DoctorController@get_prescription_by_id']);
});

$router->group(['prefix'=>'auth'],function() use ($router){
    $router->post('/login',["uses"=>'AuthController@login']);
    $router->post('/validate-token',['uses'=>'AuthController@validate_token']);
});

$router->group(['prefix'=>'patient','middleware'=>'role_user:3'],function() use ($router){
    $router->get('/get-my-prescriptions/{page_no}',['uses'=>'PatientController@get_my_prescriptions']);
});

$router->group(['prefix'=>'pharmacist','middleware'=>'role_user:4'],function() use ($router){
    $router->post('/get-patient',['uses'=>'PharmacistController@get_patient_by_id']);
    $router->get('/get-prescription/{patient_id}',['uses'=>'PharmacistController@get_prescriptions']);
});

