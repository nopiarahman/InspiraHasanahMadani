<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class pelanggan extends Model
{
    /* soft delete */
    use SoftDeletes;
    protected $table = 'pelanggan';
    protected $guarded = ['id', 'created_at', 'updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get all of the pembelian for the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelian()
    {
        return $this->hasOne(pembelian::class);
    }
    /**
     * Get the kavling associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kavling()
    {
        return $this->hasOne(kavling::class);
    }
    /**
     * Get the rumah associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rumah()
    {
        return $this->hasOne(rumah::class);
    }
    /**
     * Get the kios associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kios()
    {
        return $this->hasOne(kios::class);
    }
    /**
     * Get the user associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the transferUnit associated with the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transferUnit()
    {
        return $this->hasOne(transferUnit::class);
    }

    /**
     * Get all of the dp for the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dp()
    {
        return $this->hasMany(dp::class);
    }
    /**
     * Get all of the cicilan for the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cicilan()
    {
        return $this->hasMany(cicilan::class);
    }
    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }
    /**
     * Get all of the tambahan for the pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tambahan()
    {
        return $this->hasMany(tambahan::class);
    }
}
