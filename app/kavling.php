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
}
