<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    use HasFactory;
    protected $table = 'gudang';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get the alokasiGudang that owns the gudang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alokasiGudang()
    {
        return $this->hasMany(alokasiGudang::class);
    }
    /**
     * Get all of the transaksi for the gudang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
/**
 * Get the transaksi that owns the gudang
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function transaksi()
{
    return $this->belongsTo(transaksi::class);
}
}
