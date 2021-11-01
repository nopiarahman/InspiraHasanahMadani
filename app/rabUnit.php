<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rabUnit extends Model
{
    protected $table = 'rabunit';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the transaksi associated with the rabUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaksi()
    {
        return $this->hasOne(transaksi::class);
    }    
}
