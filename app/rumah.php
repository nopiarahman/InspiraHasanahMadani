<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rumah extends Model
{
    protected $table = 'rumah';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the kavling that owns the rumah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kavling()
    {
        return $this->belongsTo(kavling::class);
    }
    /**
     * Get the pembelian associated with the rumah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembelian()
    {
        return $this->hasOne(pembelian::class);
    }
    /**
     * Get the pelanggan that owns the rumah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
}
