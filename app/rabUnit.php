<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rabUnit extends Model
{
    protected $table = 'rabUnit';
    protected $guarded = ['id','created_at','updated_at'];
}
