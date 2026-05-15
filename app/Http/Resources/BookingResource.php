<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'peminjam'      => $this->whenLoaded('user', fn() => [
                'id'    => $this->user->id,
                'nama'  => $this->user->name,
                'email' => $this->user->email,
            ]),
            'peralatan'     => $this->whenLoaded('equipment', fn() => [
                'id'   => $this->equipment->id,
                'nama' => $this->equipment->name,
            ]),
            'tanggal_pinjam'  => $this->borrow_date->format('d-m-Y'),
            'tanggal_kembali' => $this->return_date->format('d-m-Y'),
            'status'          => $this->status,
            'dibuat_pada'     => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
