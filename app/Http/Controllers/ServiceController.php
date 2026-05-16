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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_hours' => ['nullable', 'integer', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:0', 'max:59'],
        ]);

        $duration = $this->durationFromRequest($request);

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
            'duration' => $duration,
            'is_active' => true,
        ]);

        return redirect('/business/profile')
            ->with('success', 'Service added to your business successfully.');
    }
    public function edit(Service $service)
    {
        $this->ensureServiceBelongsToCurrentBusiness($service);

        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $this->ensureServiceBelongsToCurrentBusiness($service);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_hours' => ['nullable', 'integer', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:0', 'max:59'],
        ]);

        $duration = $this->durationFromRequest($request);

        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $duration,
        ]);

        return redirect('/services')
            ->with('success', 'Service updated successfully.');
    }

    public function deactivate(Service $service)
    {
        $this->ensureServiceBelongsToCurrentBusiness($service);

        $service->is_active = false;
        $service->save();

        return redirect('/services')
            ->with('success', 'Service deactivated successfully.');
    }

    private function ensureServiceBelongsToCurrentBusiness(Service $service): void
    {
        $business = Business::where('user_id', Auth::id())->firstOrFail();

        abort_unless($service->business_id === $business->id, 403);
    }

    private function durationFromRequest(Request $request): int
    {
        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $duration = ($hours * 60) + $minutes;

        abort_if($duration < 1, 422, 'Duration must be at least 1 minute.');

        return $duration;
    }
}
