<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
</head>
<body>

@include('partials.nav')

<h1>My Appointments</h1>

<p>
    <a href="/">Home</a> |
    <a href="/businesses">Book Another Service</a>
</p>
@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@if($bookings->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Service</th>
            <th>Business</th>
            <th>Date</th>
            <th>Time</th>
            <th>Staff</th>
            <th>Status</th>
            <th>Deposit Status</th>
            <th>Reminder Status</th>
            <th>Deposit Action</th>
            <th>Booking Action</th>
        </tr>

        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->service->business->business_name }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->booking_time }}</td>
                <td>{{ $booking->staff_name }}</td>
                <td>
                    @if($booking->status === 'pending')
                        <span style="color: orange;">Pending</span>
                    @endif

                    @if($booking->status === 'confirmed')
                        <span style="color: blue;">Confirmed</span>
                    @endif

                    @if($booking->status === 'completed')
                        <span style="color: green;">Completed</span>
                    @endif

                    @if($booking->status === 'cancelled')
                        <span style="color: red;">Cancelled</span>
                    @endif
                </td>
                
                <td>{{ $booking->deposit_paid ? 'Paid' : 'Not Paid' }}</td>

                <td>
                    {{ $booking->reminder_sent ? 'Sent' : 'Not Sent' }}
                </td>

                <td>
                    @if($booking->status === 'cancelled')
                        Not available
                    @elseif(!$booking->deposit_paid)
                        <form method="POST" action="{{ url('/bookings/' . $booking->id . '/pay') }}">
                            @csrf
                            <button type="submit">Pay Deposit</button>
                        </form>
                    @else
                        Paid
                    @endif
                </td>

                <td>
                    @if($booking->status !== 'cancelled')
                        <form method="POST" action="{{ url('/bookings/' . $booking->id . '/cancel') }}">
                            @csrf
                            <button type="submit">Cancel Booking</button>
                        </form>
                    @else
                        Cancelled
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>You have no appointments yet.</p>
@endif

</body>
</html>
