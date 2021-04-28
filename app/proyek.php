<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyek extends Model
{
    protected $table = 'proyek';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */
}
