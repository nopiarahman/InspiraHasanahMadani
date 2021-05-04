<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    protected $table = 'pembelian';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the pelanggan that owns the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
    /**
     * Get the kavling that owns the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kavling()
    {
        return $this->belongsTo(kavling::class);
    }
}
