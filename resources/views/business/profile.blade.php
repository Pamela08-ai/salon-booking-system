<!DOCTYPE html>
<html>
<head>
    <title>My Business Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    @if($business)

        <div class="card border-0 shadow-sm rounded-5 mb-4">
            <div class="card-body p-5">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                    <div>
                        <h1 class="display-5 fw-bold mb-3">
                            {{ $business->business_name }}
                        </h1>

                        <p class="text-muted mb-2">
                            <strong>Location:</strong>
                            {{ $business->location }}
                        </p>

                        <p class="lead mb-0">
                            {{ $business->description }}
                        </p>

                        <p class="text-muted mt-3 mb-0">
                            <strong>Opening Hours:</strong>
                            @if($business->opening_time && $business->closing_time)
                                {{ substr($business->opening_time, 0, 5) }} - {{ substr($business->closing_time, 0, 5) }}
                            @else
                                Not set yet
                            @endif
                        </p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="/business/edit"
                           class="btn btn-dark rounded-pill px-4">
                            Edit Profile
                        </a>

                        <a href="/businesses/{{ $business->id }}"
                           class="btn btn-outline-dark rounded-pill px-4">
                            View Public Page
                        </a>
                    </div>

                </div>

            </div>
        </div>

        <div class="mb-4">
            <h2 class="fw-bold mb-1">
                Business Management
            </h2>

            <p class="text-muted">
                Manage services, bookings, and business analytics.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <h3 class="h5 fw-bold mb-3">
                            Add Service
                        </h3>

                        <p class="text-muted flex-grow-1">
                            Create a new service customers can book online.
                        </p>

                        <a href="/services/create"
                           class="btn btn-dark rounded-pill w-100">
                            Add Service
                        </a>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <h3 class="h5 fw-bold mb-3">
                            Manage Services
                        </h3>

                        <p class="text-muted flex-grow-1">
                            Edit, deactivate, and organise your services.
                        </p>

                        <a href="/services"
                           class="btn btn-outline-dark rounded-pill w-100">
                            Manage
                        </a>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <h3 class="h5 fw-bold mb-3">
                            Manage Bookings
                        </h3>

                        <p class="text-muted flex-grow-1">
                            Confirm, complete, and manage appointments.
                        </p>

                        <a href="/bookings"
                           class="btn btn-outline-dark rounded-pill w-100">
                            View Bookings
                        </a>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <h3 class="h5 fw-bold mb-3">
                            Dashboard
                        </h3>

                        <p class="text-muted flex-grow-1">
                            View business insights and booking analytics.
                        </p>

                        <a href="/dashboard"
                           class="btn btn-outline-dark rounded-pill w-100">
                            Open Dashboard
                        </a>

                    </div>
                </div>
            </div>

        </div>

    @else

        <div class="card border-0 shadow-sm rounded-5 p-5 text-center">

            <h1 class="display-6 fw-bold mb-3">
                No Business Profile Found
            </h1>

            <p class="text-muted mb-4">
                Create your business profile to start managing services and bookings.
            </p>

            <a href="/business/create"
               class="btn btn-dark rounded-pill px-4">
                Create Business Profile
            </a>

        </div>

    @endif

</div>

</body>
</html>
