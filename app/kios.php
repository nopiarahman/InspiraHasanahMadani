<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kios extends Model
{
    protected $table = 'kios';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the kavling that owns the kios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kavling()
    {
        return $this->belongsTo(kavling::class);
    }
    /**
     * Get the pembelian associated with the kios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembelian()
    {
        return $this->hasOne(pembelian::class);
    }
    /**
     * Get the pelanggan that owns the kios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
}

