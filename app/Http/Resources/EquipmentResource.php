<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'nama'        => $this->name,
            'deskripsi'   => $this->description,
            'stok'        => $this->stock,
            'status'      => $this->status,
            'dibuat_pada' => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
