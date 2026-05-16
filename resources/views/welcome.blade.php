<!DOCTYPE html>
<html>
<head>
    <title>Bookira</title>
    <style>
        .button-link {
            display: inline-block;
            padding: 8px 12px;
            border: 1px solid #333;
            border-radius: 3px;
            background: #f2f2f2;
            color: #111;
            text-decoration: none;
        }
    </style>
</head>
<body>

@include('partials.nav')

    <h1>Welcome to Bookira</h1>

    <p>
        Smart salon booking and business management platform.
    </p>

    <hr><br>

    <h2>Customer Portal</h2>

    <p>
        Browse salon businesses and book appointments.
    </p>

    <a class="button-link" href="/businesses">Book Appointment</a>

    <br><br><hr><br>

    <h2>Business Owner Portal</h2>

    <p>
        Manage your salon business, services, and bookings.
    </p>

    @guest

    <a class="button-link" href="/register">Register Your Business</a>

    <br><br>

    <a class="button-link" href="/login">Business Owner Login</a>

@else

    @if(Auth::user()->role === 'business_owner')

        <a class="button-link" href="/business/create">Create Business Profile</a>

        <br><br>

        <a class="button-link" href="/business/profile">My Business Profile</a>

        <br><br>

        <a class="button-link" href="/dashboard">Business Dashboard</a>

    @else

        <p>
            Business tools are available when you sign in as a business owner.
        </p>

    @endif

@endguest

    <br><br><hr><br>

    @guest

        <a href="/login">Login</a> |
        <a href="/register">Register</a>

    @else

        <p>
            Logged in as {{ Auth::user()->name }}
        </p>

        <a href="/my-bookings">
            My Bookings
        </a>

    @endguest

</body>
</html>
