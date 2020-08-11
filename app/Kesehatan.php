<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kesehatan extends Model
{
    protected $table = 'kesehatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tgl_isi', 'demam', 'batuk_kering', 'hidung_tersumbat', 'pilek', 'sakit_tenggorokan', 'diare',
        'sulit_bernafas', 'warga_id'
    ];

    // Relations

    public function warga () {
        return $this->belongsTo('App\Warga');
    }

    // Local Scopes

    public function scopeIsSakit ($query) {
        return $query->where('demam', '1')->orWhere('batuk_kering', '1')->orWhere('hidung_tersumbat', '1')->orWhere('pilek', '1')->orWhere('sakit_tenggorokan', '1')->orWhere('diare', '1')->orWhere('sulit_bernafas', '1');
    }

    public function scopeIsSehat ($query) {
        return $query->where('demam', '0')->where('batuk_kering', '0')->where('hidung_tersumbat', '0')->where('pilek', '0')->where('sakit_tenggorokan', '0')->where('diare', '0')->where('sulit_bernafas', '0');
    }
}
