<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
</head>
<body>

@include('partials.nav')

<h1>Business Owner - Booking Management</h1>

<a href="/services">Back to Services</a>

<br><br>

@if($bookings->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Customer</th>
            <th>Email</th>
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
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->user->email }}</td>
                <td>{{ $booking->service->name }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->booking_time }}</td>
                <td>{{ $booking->staff_name }}</td>

                <td>
                    @if($booking->status === 'pending')
                        <span style="color: orange;">Pending</span>

                        <br><br>

                        <form method="POST" action="/bookings/{{ $booking->id }}/confirm">
                            @csrf
                            <button type="submit">Confirm Appointment</button>
                        </form>
                    @endif

                    @if($booking->status === 'confirmed')
                        <span style="color: blue;">Confirmed</span>

                        <br><br>

                        <form method="POST" action="/bookings/{{ $booking->id }}/complete">
                            @csrf
                            <button type="submit">Mark Completed</button>
                        </form>
                    @endif

                    @if($booking->status === 'completed')
                        <span style="color: green;">Completed</span>
                    @endif

                    @if($booking->status === 'cancelled')
                        <span style="color: red;">Cancelled</span>
                    @endif
                </td>

                <td>&pound;{{ $booking->deposit_amount }}</td>
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

                        @if(!$booking->reminder_sent)
                            <form method="POST" action="{{ url('/bookings/' . $booking->id . '/reminder') }}">
                                @csrf
                                <button type="submit">Send Reminder</button>
                            </form>

                            <br>
                        @else
                            Reminder sent

                            <br><br>
                        @endif

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
