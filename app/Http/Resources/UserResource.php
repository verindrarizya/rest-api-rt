<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'nama' => $this->nama,
            'nik' => $this->nik,
            'kecamatan' => $this->kecamatan,
            'kelurahan' => $this->kelurahan,
            'rw' => $this->rw,
            'rt' => $this->rt,
            'status_user' => ($this->status_user == 1 ? 'rt' : 'warga'),
            'warga' => new WargaResource($this->whenLoaded('warga'))
        ];
    }
}
