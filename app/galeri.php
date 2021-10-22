<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class galeri extends Model
{
    use HasFactory;
    protected $table = 'galeri';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get the proyekweb te galeri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyekweb()
    {
        return $this->belongsTo(proyekweb::class);
    }
}
