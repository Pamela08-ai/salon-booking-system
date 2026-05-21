<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;

class Business extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'location',
        'description',
        'opening_time',
        'closing_time',
    ];

    public function services()
    {
        // Each business can offer many services.
        return $this->hasMany(Service::class);
    }

    public function user()
    {
        // The business belongs to the owner who created it.
        return $this->belongsTo(User::class);
    }
}
