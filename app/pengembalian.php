<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $guarded = ['id','created_at','updated_at'];

}
