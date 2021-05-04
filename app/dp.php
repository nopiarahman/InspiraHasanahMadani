<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dp extends Model
{
    protected $table = 'dp';
    protected $guarded = ['id','created_at','updated_at'];
}
