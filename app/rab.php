<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rab extends Model
{
    protected $table = 'rab';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the rab associated with the rab
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaksi()
    {
        return $this->hasOne(transaksi::class);
    }
}
