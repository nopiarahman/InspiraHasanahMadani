<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyek extends Model
{
    protected $table = 'proyek';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get all of the kavling for the proyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kavling()
    {
        return $this->hasMany(kavling::class);
    }
    /**
     * Get all of the user for the proyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany(user::class);
    }
}
