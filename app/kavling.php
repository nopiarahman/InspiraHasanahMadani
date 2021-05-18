<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kavling extends Model
{
    protected $table = 'kavling';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the proyek that owns the kavling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }
    /**
     * Get the pembelian associated with the kavling
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pembelian()
    {
        return $this->hasOne(pembelian::class);
    }
    /**
     * Get the rumah associated with the kavling
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rumah()
    {
        return $this->hasOne(rumah::class);
    }
    /**
     * Get the kios associated with the kavling
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kios()
    {
        return $this->hasOne(kios::class);
    }
}
