<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Warga extends Model
{
    protected $table = 'warga';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_kk', 'user_id', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'no_hp', 
        'flag_hamil', 'flag_paru', 'flag_jantung', 'flag_autoimun', 'flag_diabet', 'flag_ginjal',
        'flag_liver', 'flag_hipertensi', 'flag_perokok'
    ];

    // Relations

    public function user () {
        return $this->belongsTo('App\User');
    }

    public function kesejahteraan () {
        return $this->hasOne('App\Kesejahteraan');
    }

    public function kesehatan () {
        return $this->hasMany('App\Kesehatan');
    }

    public function latestKesehatan () {
        return $this->hasOne('App\Kesehatan')->latest();
    }
}
