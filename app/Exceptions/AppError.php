<?php
namespace App\Exceptions;

use App\Exceptions\ExceptionModels;


class AppError extends \Exception{

    private $custom_message;

    public function __construct($custom_message , $code = 500 , $exception_model) {
        $this->custom_message = $custom_message;
        parent::__construct($exception_model , $code);
    }

    public function error_message(){
        return $this->custom_message;
    }
}