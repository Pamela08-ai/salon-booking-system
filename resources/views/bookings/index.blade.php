<!DOCTYPE html>
<html>
<head>
    <title>Booking Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1">
                Booking Management
            </h1>

            <p class="text-muted mb-0">
                Manage customer appointments, deposits, reminders, and booking status.
            </p>
        </div>

        <a href="/services" class="btn btn-outline-dark rounded-pill px-4">
            Back to Services
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">
            {{ session('success') }}
        </div>
    @endif

    @if($bookings->count() > 0)

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">

                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3">Customer</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Service</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Time</th>
                            <th class="p-3">Staff</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Deposit</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($bookings as $booking)

                            <tr>

                                <td class="p-3 fw-semibold">
                                    {{ $booking->user->name }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->user->email }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->service->name }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->booking_date }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->booking_time }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->staff_name }}
                                </td>

                                <td class="p-3">

                                    @if($booking->status === 'pending')
                                        <span class="badge rounded-pill text-bg-warning mb-2">
                                            Pending
                                        </span>

                                        <form method="POST" action="/bookings/{{ $booking->id }}/confirm">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                Confirm
                                            </button>
                                        </form>
                                    @endif

                                    @if($booking->status === 'confirmed')
                                        <span class="badge rounded-pill text-bg-primary mb-2">
                                            Confirmed
                                        </span>

                                        <form method="POST" action="/bookings/{{ $booking->id }}/complete">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                                Mark Completed
                                            </button>
                                        </form>
                                    @endif

                                    @if($booking->status === 'completed')
                                        <span class="badge rounded-pill text-bg-success">
                                            Completed
                                        </span>
                                    @endif

                                    @if($booking->status === 'cancelled')
                                        <span class="badge rounded-pill text-bg-danger">
                                            Cancelled
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    <div class="mb-2">
                                        <strong>Amount:</strong>
                                        &pound;{{ $booking->deposit_amount }}
                                    </div>

                                    @if($booking->deposit_paid)
                                        <span class="badge rounded-pill text-bg-success">
                                            Paid
                                        </span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">
                                            Not Paid
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    @if($booking->status !== 'cancelled')

                                        @if(!$booking->reminder_sent)

                                            <form method="POST" action="{{ url('/bookings/' . $booking->id . '/reminder') }}" class="mb-2">
                                                @csrf

                                                <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                                    Send Reminder
                                                </button>
                                            </form>

                                        @else

                                            <div class="text-success mb-2">
                                                Reminder Sent
                                            </div>

                                        @endif

                                        <form method="POST" action="{{ url('/bookings/' . $booking->id . '/cancel') }}">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                Cancel Booking
                                            </button>
                                        </form>

                                    @else

                                        <span class="text-muted">
                                            No actions available
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    @else

        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">

            <h2 class="h4 fw-bold">
                No bookings found
            </h2>

            <p class="text-muted">
                Customer appointments will appear here once bookings are made.
            </p>

        </div>

    @endif

</div>

</body>
</html>