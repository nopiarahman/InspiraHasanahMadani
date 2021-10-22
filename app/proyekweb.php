<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyekweb extends Model
{
    use HasFactory;
    protected $table = 'proyekweb';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get all of the galeri for the proyekweb
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galeri()
    {
        return $this->hasMany(galeri::class);
    }
}
