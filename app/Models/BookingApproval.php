<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingApproval extends Model
{
    protected $guarded = ['id'];

public function booking()
{
    return $this->belongsTo(Booking::class);
}

public function approver()
{
    return $this->belongsTo(User::class, 'approver_id');
}
}
