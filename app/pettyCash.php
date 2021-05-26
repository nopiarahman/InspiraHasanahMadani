<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pettyCash extends Model
{
    protected $table = 'pettycash';
    protected $guarded = ['id','created_at','updated_at'];
}
