<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $business = \App\Models\Business::where('user_id', auth()->id())->first();

        if (!$business) {
            return redirect('/business/create')
                ->with('success', 'Please create a business profile first.');
        }

        $services = Service::where('business_id', $business->id)->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $business = Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return redirect('/business/create')
                ->with('success', 'Please create a business profile before adding services.');
        }

        Service::create([
            'business_id' => $business->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'is_active' => true,
        ]);

        return redirect('/business/profile')
            ->with('success', 'Service added to your business successfully.');
    }
}