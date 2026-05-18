<!DOCTYPE html>
<html>
<head>
    <title>Business Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    @if(!$business)

        <div class="card border-0 shadow-sm rounded-5 p-5 text-center">
            <h1 class="display-6 fw-bold">Create Your Business Profile</h1>

            <p class="text-muted">
                You need to create a business profile before viewing dashboard analytics.
            </p>

            <a href="/business/create" class="btn btn-dark rounded-pill px-4">
                Create Business Profile
            </a>
        </div>

    @else

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-6 fw-bold mb-1">
                    {{ $business->business_name }} Dashboard
                </h1>

                <p class="text-muted mb-0">
                    Overview of bookings, deposits, cancellations, and business performance.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="/services" class="btn btn-outline-dark rounded-pill px-4">
                    Services
                </a>

                <a href="/bookings" class="btn btn-dark rounded-pill px-4">
                    Bookings
                </a>
            </div>
        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Total Bookings</p>
                        <h2 class="fw-bold">{{ $totalBookings }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Deposit Revenue</p>
                        <h2 class="fw-bold">&pound;{{ $totalRevenue }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Cancellation Rate</p>
                        <h2 class="fw-bold">{{ $cancellationRate }}%</h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Pending</p>
                        <h3 class="fw-bold">{{ $pendingBookings }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Cancelled</p>
                        <h3 class="fw-bold">{{ $cancelledBookings }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Completed</p>
                        <h3 class="fw-bold">{{ $completedBookings ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1">Unpaid Deposits</p>
                        <h3 class="fw-bold">{{ $totalUnpaidDeposits }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-4">Bookings Overview</h2>

                        <canvas id="bookingChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-4">Business Insights</h2>

                        <ul class="list-unstyled">

                            @if($cancellationRate > 50)
                                <li class="mb-3">
                                    High cancellation rate detected. Review cancellation policies or deposit rules.
                                </li>
                            @endif

                            @if($totalUnpaidDeposits > 0)
                                <li class="mb-3">
                                    {{ $totalUnpaidDeposits }} active bookings have unpaid deposits.
                                </li>
                            @endif

                            @if($popularService)
                                <li class="mb-3">
                                    {{ $popularService->service->name }} is currently the most popular service.
                                </li>
                            @else
                                <li class="mb-3">
                                    No popular service data yet.
                                </li>
                            @endif

                            @if($mostBookedStaff)
                                <li class="mb-3">
                                    {{ $mostBookedStaff->staff_name }} has the highest number of bookings.
                                </li>
                            @else
                                <li class="mb-3">
                                    No staff booking data yet.
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <script>
            const ctx = document.getElementById('bookingChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Pending', 'Cancelled', 'Completed'],
                    datasets: [{
                        label: 'Bookings',
                        data: [
                            {{ $totalBookings }},
                            {{ $pendingBookings }},
                            {{ $cancelledBookings }},
                            {{ $completedBookings ?? 0 }}
                        ],
                        borderWidth: 1
                    }]
                }
            });
        </script>

    @endif

</div>

</body>
</html>