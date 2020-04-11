<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model{

    public $table = "patient";
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