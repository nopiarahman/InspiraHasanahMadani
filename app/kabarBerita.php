<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\proyek;

class kabarBerita extends Model
{
    use HasFactory;
    protected $table = 'kabarberita';
    protected $guarded = ['id','created_at','updated_at']; /* melindungi field yang tidak boleh diisi manual, lihat mass assignment */

    /**
     * Get the proyek that owns the kabarBerita
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }
}
