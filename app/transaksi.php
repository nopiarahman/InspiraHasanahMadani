<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the akun associated with the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    /**
     * Get the akun that owns the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akun()
    {
        return $this->belongsTo(akun::class);
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
    /**
     * Get the user that owns the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the gudang that owns the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get all of the gudang for the transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gudang()
    {
        return $this->hasMany(gudang::class);
    }
}
