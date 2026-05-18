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
        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
        ]);

        if (Business::where('user_id', Auth::id())->exists()) {
            return redirect('/business/profile')
                ->with('success', 'You already have a business profile.');
        }

        Business::create([
            'user_id' => Auth::id(),
            'business_name' => $request->business_name,
            'location' => $request->location,
            'description' => $request->description,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ]);

        return redirect('/business/profile')
            ->with('success', 'Business profile created successfully.');
    }

    public function profile()
    {
        $business = Business::where('user_id', Auth::id())->first();

        return view('business.profile', compact('business'));
    }

    public function edit()
    {
        $business = Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return redirect('/business/create')
                ->with('success', 'Please create a business profile first.');
        }

        return view('business.edit', compact('business'));
    }

    public function update(Request $request)
    {
        $business = Business::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
        ]);

        $business->update([
            'business_name' => $request->business_name,
            'location' => $request->location,
            'description' => $request->description,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ]);

        return redirect('/business/profile')
            ->with('success', 'Business profile updated successfully.');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $businesses = Business::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('business_name', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('services', function ($query) use ($search) {
                            $query->where('is_active', true)
                                ->where(function ($query) use ($search) {
                                    $query->where('name', 'like', '%' . $search . '%')
                                        ->orWhere('description', 'like', '%' . $search . '%');
                                });
                        });
                });
            })
            ->orderBy('business_name')
            ->get();

        return view('business.index', compact('businesses', 'search'));
    }

    public function show(Business $business)
    {
        $services = $business->services()
            ->where('is_active', true)
            ->get();

        return view('business.show', compact('business', 'services'));
    }
}
