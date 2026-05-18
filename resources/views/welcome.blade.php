<!DOCTYPE html>
<html>
<head>
    <title>Bookira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #eee8ff, #ffe6f7, #ffffff); min-height: 100vh;">

@include('partials.nav')

<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1 class="display-4 fw-bold mb-3">
                Book local salon and beauty services
            </h1>

            <p class="lead mb-4">
                Discover salons, manage appointments, and support small beauty businesses with smarter booking tools.
            </p>

            <div class="card border-0 shadow-lg rounded-5 p-4" style="max-width: 650px;">
                <div class="d-grid gap-3">
                    <a href="/businesses" class="btn btn-dark btn-lg rounded-pill">
                        Book Appointment
                    </a>

                    @guest
                        <a href="/register" class="btn btn-outline-dark btn-lg rounded-pill">
                            Register Your Business
                        </a>

                        <a href="/login" class="btn btn-light btn-lg rounded-pill border">
                            Login
                        </a>
                    @else
                        @if(Auth::user()->role === 'business_owner')
                            <a href="/business/profile" class="btn btn-outline-dark btn-lg rounded-pill">
                                Go to My Business
                            </a>

                            <a href="/dashboard" class="btn btn-light btn-lg rounded-pill border">
                                View Dashboard
                            </a>
                        @else
                            <a href="/my-bookings" class="btn btn-outline-dark btn-lg rounded-pill">
                                My Appointments
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>