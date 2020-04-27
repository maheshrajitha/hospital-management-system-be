<?php

namespace App\Exceptions;

class ExceptionModels 
{
    public const USER_EXISTS = 'USER_EXISTS';
    public const LOGIN_ERROR = 'LOGIN_ERROR';
    public const INVALIED_REQUEST = 'INVALIED_REQUEST';
    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const NOT_FOUND ='NOT_FOUND';
    public const PRESENTED_LECTURE = 'PRESENTED_LECTURE';
    public const YOU_ARE_NOT_A_VALIED_STUDENT = 'YOU_ARE_NOT_A_VALIED_STUDENT';
    public const LEFT_EARLY = 'LEFT_EARLY';
    public const TODAY_NO_LECTURES = 'TODAY_NO_LECTURES';
}