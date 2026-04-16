<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_no',
        'room_type',
        'floor',
        'price',
        'status',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}