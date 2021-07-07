<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dp extends Model
{
    protected $table = 'dp';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the pembelian associated with the dp
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    /**
     * Get the pembelian that owns the dp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembelian()
    {
        return $this->belongsTo(pembelian::class);
    }
    /**
     * Get the pelanggan that owns the dp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
}
