<?php
namespace App\Exceptions;

use App\Exceptions\ExceptionModels;
use Illuminate\Http\Response;
use App\Exceptions\AppError;


trait ExceptionTrait{
    /**
     * Application Exceptions Handled By This Method
     * 
     */
    public function exception_handler($request,$exception){
        if($exception instanceof AppError){
            return response()->json([
                'MESSAGE'=>$exception->error_message(),
                'CODE'=>$exception->getMessage(),
            ],$exception->getCode());
        }else
            return response()->json([
                'MESSAGE'=>$exception->getMessage(),
                'CODE'=>$exception->getMessage(),
            ],500);
    }
}