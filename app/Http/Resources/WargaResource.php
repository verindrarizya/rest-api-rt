<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WargaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'no_kk' => $this->no_kk,
            'user_id' => $this->user_id,
            'jenis_kelamin' => ($this->jenis_kelamin == 'L' ? 'Laki - laki' : 'Perempuan'),
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'flag_hamil' => $this->flag_hamil,
            'flag_paru' => $this->flag_paru,
            'flag_jantung' => $this->flag_jantung,
            'flag_autoimun' => $this->flag_autoimun,
            'flag_diabet' => $this->flag_diabet,
            'flag_ginjal' => $this->flag_ginjal,
            'flag_liver' => $this->flag_liver,
            'flag_hipertensi' => $this->flag_hipertensi,
            'flag_perokok' => $this->flag_perokok
        ];
    }
}
