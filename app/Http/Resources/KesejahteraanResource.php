<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KesejahteraanResource extends JsonResource
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
            'penghasilan' => $this->penghasilan,
            'flag_phk' => $this->flag_phk,
            'flag_usaha' => $this->flag_usaha,
        ];
    }
}
