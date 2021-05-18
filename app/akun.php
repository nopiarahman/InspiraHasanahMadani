<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    protected $table = 'akun';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get all of the transaksi for the akun
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    
    /**
     * Get all of the transaksi for the akun
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(transaksi::class);
    }
}
