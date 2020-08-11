<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KesehatanResource extends JsonResource
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
            'tgl_isi' => $this->tgl_isi,
            'demam' => $this->demam,
            'batuk_kering' => $this->batuk_kering,
            'pilek' => $this->pilek,
            'sakit_tenggorokan' => $this->sakit_tenggorokan,
            'diare' => $this->diare,
            'sulit_bernafas' => $this->sulit_bernafas,
        ];
    }
}
