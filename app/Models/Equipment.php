<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'description',
        'stock',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}