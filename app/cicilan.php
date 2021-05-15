<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cicilan extends Model
{
    protected $table = 'cicilan';
    protected $guarded = ['id','created_at','updated_at'];
}
