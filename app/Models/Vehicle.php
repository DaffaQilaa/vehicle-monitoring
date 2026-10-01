<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = ['id'];

public function location()
{
    return $this->belongsTo(Location::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
