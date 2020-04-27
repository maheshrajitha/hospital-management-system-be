<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model{

    public $table = "prescription";
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    
    protected $fillable = [
        'email',
    ];

    
    protected $hidden = [
    ];
}