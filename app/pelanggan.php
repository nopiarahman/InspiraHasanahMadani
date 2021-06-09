<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get all of the pembelian for the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelian()
    {
        return $this->hasMany(pembelian::class);
    }
    /**
     * Get the kavling associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kavling()
    {
        return $this->hasOne(kavling::class);
    }
}
