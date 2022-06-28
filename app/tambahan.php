<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tambahan extends Model
{
    use HasFactory;
    protected $table = 'tambahan';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get the pelanggan that owns the tambahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {       
        return $this->belongsTo(pelanggan::class);
    }
    /**
     * Get the tambahanDetail associated with the tambahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tambahanDetail()
    {
        return $this->hasOne(tambahanDetail::class);
    }
}
