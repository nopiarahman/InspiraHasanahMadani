<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kios extends Model
{
    protected $table = 'kios';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the kavling that owns the kios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kavling()
    {
        return $this->belongsTo(kavling::class);
    }
}

