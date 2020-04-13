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
    $router->get('/doctor-count',['uses'=>'AdminController@get_doctor_table_size']);
    $router->post('/add-new-patient',['uses'=>'AdminController@add_new_patient']);
    $router->get('/get-all-patients/{page_no}',['uses'=>'AdminController@get_all_patients']);
    $router->post('/add-new-pharmacist',['uses'=>'AdminController@addNewPharmacist']);
    $router->get('/all-pharmacists/{page_no}',['uses'=>'AdminController@getAllPharmacists']);
});

$router->group(['prefix'=>'auth'],function() use ($router){
    $router->post('/login',["uses"=>'AuthController@login']);
});


