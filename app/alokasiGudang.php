<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alokasiGudang extends Model
{
    use HasFactory;
    protected $table = 'alokasigudang';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get all of the gudang for the alokasiGudang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gudang()
    {
        return $this->belongsTo(gudang::class);
    }
        /**
     * Get the rab that owns the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rab()
    {
        return $this->belongsTo(rab::class);
    }
    /**
     * Get the rabUnit that owns the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rabunit()
    {
        return $this->belongsTo(rabUnit::class);
    }
}
