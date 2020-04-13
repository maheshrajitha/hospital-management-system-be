<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model{

    public $table = "pharmacist";
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