<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $business = Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return redirect('/business/create')
                ->with('success', 'Please create a business profile first.');
        }

        $bookings = Booking::with(['service', 'user'])
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('bookings.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'booking_date' => ['required', 'date'],
            'booking_time' => ['required', 'date_format:H:i'],
            'staff_name' => ['required', 'string', 'max:255'],
        ]);

        $service = Service::with('business')
            ->where('is_active', true)
            ->findOrFail($validated['service_id']);

        $business = $service->business;

        if ($business->opening_time && $business->closing_time) {
            $bookingTime = $validated['booking_time'];
            $openingTime = substr($business->opening_time, 0, 5);
            $closingTime = substr($business->closing_time, 0, 5);

            if ($bookingTime < $openingTime || $bookingTime > $closingTime) {
                return back()
                    ->withErrors([
                        'booking_time' => 'Please choose a time between ' . $openingTime . ' and ' . $closingTime . '.',
                    ])
                    ->withInput();
            }
        }

        Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'status' => 'pending',
            'deposit_amount' => 20,
            'deposit_paid' => false,
            'staff_name' => $validated['staff_name'],
        ]);

        return redirect('/my-bookings')
            ->with('success', 'Appointment booked successfully with ' . $service->business->business_name . '.');
    }

    public function payDeposit($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        abort_if($booking->status === 'cancelled', 403);

        $booking->deposit_paid = true;
        $booking->save();

        return back()->with('success', 'Deposit paid successfully.');
    }
    public function sendReminder($id)
    {
        $business = Business::where('user_id', Auth::id())->firstOrFail();

        $booking = Booking::whereHas('service', function ($query) use ($business) {
            $query->where('business_id', $business->id);
        })->findOrFail($id);

        $booking->reminder_sent = true;

        $booking->save();

        return back()->with('success', 'Reminder marked as sent.');
    }

    public function cancel($id)
    {
        $booking = $this->findBookingForCurrentUser($id);

        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function dashboard()
    {
        $business = Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return view('dashboard', [
                'business' => null,
                'totalBookings' => 0,
                'totalRevenue' => 0,
                'pendingBookings' => 0,
                'cancelledBookings' => 0,
                'completedBookings' => 0,
                'popularService' => null,
                'totalUnpaidDeposits' => 0,
                'mostBookedStaff' => null,
                'cancellationRate' => 0,
            ]);
        }

        $totalBookings = Booking::whereHas('service', function ($query) use ($business) {
            $query->where('business_id', $business->id);
        })->count();

        $totalRevenue = Booking::where('deposit_paid', true)
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })->sum('deposit_amount');

        $pendingBookings = Booking::where('status', 'pending')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })->count();

        $cancelledBookings = Booking::where('status', 'cancelled')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })->count();

        $completedBookings = Booking::where('status', 'completed')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })->count();

        $popularService = Booking::select('service_id')
            ->selectRaw('count(*) as total')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->groupBy('service_id')
            ->orderByDesc('total')
            ->with('service')
            ->first();

        $totalUnpaidDeposits = Booking::where('deposit_paid', false)
            ->where('status', '!=', 'cancelled')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->count();

        $mostBookedStaff = Booking::select('staff_name')
            ->selectRaw('count(*) as total')
            ->whereNotNull('staff_name')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->groupBy('staff_name')
            ->orderByDesc('total')
            ->first();

        $cancellationRate = $totalBookings > 0
            ? round(($cancelledBookings / $totalBookings) * 100, 1)
            : 0;

        return view('dashboard', compact(
            'business',
            'totalBookings',
            'totalRevenue',
            'pendingBookings',
            'cancelledBookings',
            'completedBookings',
            'popularService',
            'totalUnpaidDeposits',
            'mostBookedStaff',
            'cancellationRate'
        ));
    }
    public function myBookings()
    {
        $bookings = Booking::with('service.business')
            ->where('user_id', Auth::id())
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }

    public function confirm($id)
    {
        $business = Business::where('user_id', Auth::id())->firstOrFail();

        $booking = Booking::whereHas('service', function ($query) use ($business) {
            $query->where('business_id', $business->id);
        })->findOrFail($id);

        $booking->status = 'confirmed';
        $booking->save();
        return back()->with('success', 'Appointment confirmed.');
    }

    public function complete($id)
    {
        $business = Business::where('user_id', Auth::id())->firstOrFail();

        $booking = Booking::whereHas('service', function ($query) use ($business) {
            $query->where('business_id', $business->id);
        })->findOrFail($id);

        $booking->status = 'completed';
        $booking->save();
        return back()->with('success', 'Appointment marked as completed.');
    }

    private function findBookingForCurrentUser($id): Booking
    {
        if (Auth::user()->role === 'customer') {
            return Booking::where('user_id', Auth::id())->findOrFail($id);
        }

        if (Auth::user()->role === 'business_owner') {
            $business = Business::where('user_id', Auth::id())->firstOrFail();

            return Booking::whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })->findOrFail($id);
        }

        abort(403);
    }
}
