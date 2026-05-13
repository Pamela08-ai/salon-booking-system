<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Business extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'location',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}