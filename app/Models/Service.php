<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\Business;

class Service extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'description',
        'price',
        'duration',
        'is_active',
    ];


    public function business()
    {
        // Services belong to a business, which links bookings back to the owner.
        return $this->belongsTo(Business::class);
    }

    public function bookings()
    {
        // Old bookings stay linked even if the service is later deactivated.
        return $this->hasMany(Booking::class);
    }

    public function formattedDuration(): string
    {
        // Show service length in a nicer way, for example 90 minutes becomes 1 hour 30 minutes.
        $hours = intdiv($this->duration, 60);
        $minutes = $this->duration % 60;
        $parts = [];

        if ($hours > 0) {
            $parts[] = $hours . ' ' . ($hours === 1 ? 'hour' : 'hours');
        }

        if ($minutes > 0 || $hours === 0) {
            $parts[] = $minutes . ' ' . ($minutes === 1 ? 'minute' : 'minutes');
        }

        return implode(' ', $parts);
    }
}
