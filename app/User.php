<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Builder;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'nama', 'nik', 'kecamatan', 'kelurahan', 'rw', 'rt', 'rt',
        'status_user'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // Relations

    public function warga () {
        return $this->hasOne('App\Warga');
    }

    // local Scopes
    public function scopeGetWarga ($query, $kecamatan, $kelurahan, $rw, $rt) {
        return $query->where([
                        ['kecamatan', $kecamatan],
                        ['kelurahan', $kelurahan],
                        ['rw', $rw],
                        ['rt', $rt],
                        ['status_user', 2]
        ]);
    }
}
