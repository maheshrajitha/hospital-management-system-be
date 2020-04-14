<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model{

    public $table = "staff";
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    
    protected $fillable = [
        'email','job_role'
    ];

    
    protected $hidden = [
    ];
}