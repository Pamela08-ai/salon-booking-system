<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request)
    {
        $business = Business::create([
            'user_id' => Auth::id(),
            'business_name' => $request->business_name,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect('/business/profile')
            ->with('success', 'Business profile created successfully.');
    }

    public function profile()
    {
        $business = Business::where('user_id', Auth::id())->first();

        return view('business.profile', compact('business'));
    }

    public function index()
    {
        $businesses = Business::all();

        return view('business.index', compact('businesses'));
    }

    public function show(Business $business)
    {
        $services = $business->services()
            ->where('is_active', true)
            ->get();

        return view('business.show', compact('business', 'services'));
    }
}