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
    /**
     * Get the rumah that owns the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rumah()
    {
        return $this->belongsTo(rumah::class);
    }
    /**
     * Get the kiso that owns the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kios()
    {
        return $this->belongsTo(kios::class);
    }
    public function cicilan()
    {
        return $this->hasMany(cicilan::class);
    }
    /**
     * Get all of the dp for the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dp()
    {
        return $this->hasMany(dp::class);
    }
    /**
     * Get all of the tambahanDetail for the pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tambahanDetail()
    {
        return $this->hasMany(tambahanDetail::class);
    }
}
