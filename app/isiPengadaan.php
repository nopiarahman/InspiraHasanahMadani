<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class isiPengadaan extends Model
{
    protected $table = 'isiPengadaan';
    protected $guarded = ['id','created_at','updated_at'];
}
