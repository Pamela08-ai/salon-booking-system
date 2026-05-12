<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'booking_date',
        'booking_time',
        'staff_name',
        'status',
        'deposit_amount',
        'deposit_paid',
        'notes',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}