<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kasPendaftaran extends Model
{
    protected $table = 'kaspendaftaran';
    protected $guarded = ['id','created_at','updated_at'];
}
