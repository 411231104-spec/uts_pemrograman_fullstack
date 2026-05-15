<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            [
                'name'        => 'Kamera DSLR Canon EOS 200D',
                'description' => 'Kamera DSLR untuk kebutuhan fotografi studio dan outdoor.',
                'stock'       => 3,
                'status'      => 'available',
            ],
            [
                'name'        => 'Tripod Profesional Manfrotto',
                'description' => 'Tripod aluminium kokoh untuk mendukung kamera dan camcorder.',
                'stock'       => 5,
                'status'      => 'available',
            ],
            [
                'name'        => 'Microphone Condenser Rode NT1',
                'description' => 'Mikrofon kondenser berkualitas tinggi untuk rekaman vokal dan instrumen.',
                'stock'       => 4,
                'status'      => 'available',
            ],
            [
                'name'        => 'Laptop MacBook Pro 14"',
                'description' => 'Laptop untuk editing video dan desain grafis.',
                'stock'       => 2,
                'status'      => 'available',
            ],
            [
                'name'        => 'Proyektor Epson EB-X500',
                'description' => 'Proyektor untuk presentasi dan screening.',
                'stock'       => 1,
                'status'      => 'maintenance',
            ],
            [
                'name'        => 'Ring Light 18 Inch',
                'description' => 'Lampu ring untuk kebutuhan vlogging, live streaming, dan foto produk.',
                'stock'       => 6,
                'status'      => 'available',
            ],
        ];

        foreach ($equipments as $item) {
            Equipment::create($item);
        }
    }
}
