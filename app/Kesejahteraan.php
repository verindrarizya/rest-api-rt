<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;

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

    // Local Scope
    
    public function scopeUsaha ($query) {
        return $query->where('flag_usaha', '1');
    }

    public function scopeTidakUsaha ($query) {
        return $query->where('flag_usaha', '0');
    }

    public function scopePehaka ($query) {
        return $query->where('flag_phk', '1');
    }

    public function scopeBekerja ($query) {
        return $query->where('flag_phk', '0');
    }
    
    public function scopePenghasilan ($query, $penghasilan) {
        return $query->where('penghasilan', $penghasilan);
    }
}
