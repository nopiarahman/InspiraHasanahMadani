<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cicilan extends Model
{
    protected $table = 'cicilan';
    protected $guarded = ['id','created_at','updated_at'];

    // public function pembelian()
    // {
    //     return $this->hasMany(pembelian::class);
    // }

    /**
     * Get the pembelian that owns the cicilan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembelian()
    {
        return $this->belongsTo(pembelian::class);
    }
    /**
     * Get the pelanggan that owns the cicilan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
}
