<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rumah extends Model
{
    protected $table = 'rumah';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the kavling that owns the rumah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kavling()
    {
        return $this->belongsTo(kavling::class);
    }
}
