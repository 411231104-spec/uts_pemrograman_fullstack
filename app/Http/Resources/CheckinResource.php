<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'peminjaman_id'  => $this->booking_id,
            'peminjam'       => $this->whenLoaded('booking', fn() => $this->booking->user ? [
                'id'   => $this->booking->user->id,
                'nama' => $this->booking->user->name,
            ] : null),
            'peralatan'      => $this->whenLoaded('booking', fn() => $this->booking->equipment ? [
                'id'   => $this->booking->equipment->id,
                'nama' => $this->booking->equipment->name,
            ] : null),
            'waktu_checkin'  => $this->checked_in_at->format('d-m-Y H:i:s'),
            'catatan'        => $this->notes,
            'dibuat_pada'    => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
