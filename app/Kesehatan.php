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
}
