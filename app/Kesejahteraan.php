<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kesejahteraan extends Model
{
    protected $table = 'kesejahteraan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'penghasilan', 'flag_phk', 'flag_usaha', 'warga_id'
    ];

    // Relations

    public function warga () {
        return $this->belongsTo('App\Warga');
    }
}
