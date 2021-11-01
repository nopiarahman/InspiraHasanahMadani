<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class transferUnit extends Model
{
    use SoftDeletes;
    protected $table = 'transferunit';
    protected $guarded = ['id','created_at','updated_at','deleted_at'];

    /**
     * Get the pelanggan that owns the transferUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class);
    }
    /**
     * Get the rekening that owns the transferUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rekening()
    {
        return $this->belongsTo(rekening::class);
    }
}
