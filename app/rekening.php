<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rekening extends Model
{
    protected $table = 'rekening';
    protected $guarded = ['id','created_at','updated_at'];
    
    /**
     * Get the transferUnit associated with the rekening
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transferUnit()
    {
        return $this->hasOne(transferUnit::class);
    }
}
