<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1">
                My Appointments
            </h1>

            <p class="text-muted mb-0">
                Track your bookings, deposits, and appointment status.
            </p>
        </div>

        <a href="/businesses" class="btn btn-dark rounded-pill px-4">
            Book Another Service
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
                            <th class="p-3">Service</th>
                            <th class="p-3">Business</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Time</th>
                            <th class="p-3">Staff</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Deposit</th>
                            <th class="p-3">Reminder</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($bookings as $booking)

                            <tr>

                                <td class="p-3 fw-semibold">
                                    {{ $booking->service->name }}
                                </td>

                                <td class="p-3">
                                    {{ $booking->service->business->business_name }}
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
                                        <span class="badge rounded-pill text-bg-warning">
                                            Pending
                                        </span>
                                    @endif

                                    @if($booking->status === 'confirmed')
                                        <span class="badge rounded-pill text-bg-primary">
                                            Confirmed
                                        </span>
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

                                    @if($booking->reminder_sent)
                                        <span class="badge rounded-pill text-bg-success">
                                            Sent
                                        </span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">
                                            Not Sent
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    @if($booking->status === 'cancelled')

                                        <span class="text-muted">
                                            Not available
                                        </span>

                                    @else

                                        @if(!$booking->deposit_paid)

                                            <form method="POST"
                                                  action="{{ url('/bookings/' . $booking->id . '/pay') }}"
                                                  class="d-inline">

                                                @csrf

                                                <button type="submit"
                                                        class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                                    Pay Deposit
                                                </button>

                                            </form>

                                        @endif

                                        <form method="POST"
                                              action="{{ url('/bookings/' . $booking->id . '/cancel') }}"
                                              class="d-inline">

                                            @csrf

                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                Cancel
                                            </button>

                                        </form>

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
                You have no appointments yet
            </h2>

            <p class="text-muted">
                Browse salon businesses and book your first appointment.
            </p>

            <a href="/businesses"
               class="btn btn-dark rounded-pill px-4">
                Book Appointment
            </a>

        </div>

    @endif

</div>

</body>
</html>