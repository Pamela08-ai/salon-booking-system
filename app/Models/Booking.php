<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\User;

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
        'reminder_sent',
        'notes',
    ];

    public function service()
    {
        // The service tells us which business this appointment belongs to.
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        // The user is the customer who made the booking.
        return $this->belongsTo(User::class);
    }
}
