<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailUser extends Model
{
    protected $table = 'detailUser';
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get the user associated with the detailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
