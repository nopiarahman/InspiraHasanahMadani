<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kasKecilLapangan extends Model
{
    protected $table = 'kasKecilLapangan';
    protected $guarded = ['id','created_at','updated_at'];
}
