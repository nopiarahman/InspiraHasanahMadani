<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','role','proyek_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Get the detailUser that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detailUser()
    {
        return $this->belongsTo(detailUser::class);
    }
    /**
     * Get the proyek that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }
    /**
     * Get the pelanggan that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->hasOne(pelanggan::class);
    }
    /**
     * Get the transaksi associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaksi()
    {
        return $this->hasOne(transaksi::class);
    }
    /**
     * Get the history associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function history()
    {
        return $this->hasOne(history::class);
    }
}
