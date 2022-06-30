<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tambahanDetail extends Model
{
    use HasFactory;
    protected $table = 'tambahandetail';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get the tambahan that owns the tambahanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tambahan()
    {
        return $this->belongsTo(tambahan::class);
    }
    /**
     * Get the pembelian that owns the tambahanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembelian()
    {
        return $this->belongsTo(pembelian::class);
    }
}
