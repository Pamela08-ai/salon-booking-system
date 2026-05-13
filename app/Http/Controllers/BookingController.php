<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $business = \App\Models\Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return redirect('/business/create')
                ->with('success', 'Please create a business profile first.');
        }

        $bookings = Booking::with('service')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

    public function store(Request $request)
    {
        Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
            'deposit_amount' => 20,
            'deposit_paid' => false,
            'staff_name' => $request->staff_name,
        ]);

        $businessName = Service::find($request->service_id)
            ->business
            ->business_name;

        return redirect('/my-bookings')
            ->with('success', 'Appointment booked successfully with ' . $businessName . '.');
    }

    public function payDeposit($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->deposit_paid = true;
        $booking->save();

        return back()->with('success', 'Deposit paid successfully.');
    }
    public function sendReminder($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->reminder_sent = true;

        $booking->save();

        return back()->with('success', 'Reminder marked as sent.');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function dashboard()
    {
        $business = \App\Models\Business::where('user_id', Auth::id())->first();

        if (!$business) {
            return view('dashboard', [
                'business' => null,
                'totalBookings' => 0,
                'totalRevenue' => 0,
                'pendingBookings' => 0,
                'cancelledBookings' => 0,
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
            'popularService',
            'totalUnpaidDeposits',
            'mostBookedStaff',
            'cancellationRate'
        ));
    }
    public function myBookings()
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::id())
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }

}