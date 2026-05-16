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
        return $this->belongsTo(Business::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

