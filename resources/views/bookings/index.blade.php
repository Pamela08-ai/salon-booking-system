<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
</head>
<body>

<h1>All Bookings</h1>

<a href="/services">Back to Services</a>

<br><br>

@if($bookings->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Service</th>
            <th>Date</th>
            <th>Time</th>
            <th>Staff</th>
            <th>Status</th>
            <th>Deposit Amount</th>
            <th>Deposit Paid</th>
            <th>Action</th>
        </tr>

        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->booking_time }}</td>
                <td>{{ $booking->staff_name }}</td>
                <td>{{ $booking->status }}</td>
                <td>£{{ $booking->deposit_amount }}</td>
                <td>{{ $booking->deposit_paid ? 'Yes' : 'No' }}</td>
                <td>
                    @if($booking->status !== 'cancelled')

                        @if(!$booking->deposit_paid)
                            <form method="POST" action="{{ url('/bookings/' . $booking->id . '/pay') }}">
                                @csrf
                                <button type="submit">Pay Deposit</button>
                            </form>
                        @else
                            Paid
                        @endif

                        <br>

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
    <p>No bookings found.</p>
@endif

</body>
</html>