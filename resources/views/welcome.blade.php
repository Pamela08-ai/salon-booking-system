<!DOCTYPE html>
<html>
<head>
    <title>Bookira</title>
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

    <a href="/businesses">
        <button>Book Appointment</button>
    </a>

    <br><br><hr><br>

    <h2>Business Owner Portal</h2>

    <p>
        Manage your salon business, services, and bookings.
    </p>

    @guest

    <a href="/register">
        <button>Register Your Business</button>
    </a>

    <br><br>

    <a href="/login">
        <button>Business Owner Login</button>
    </a>

@else

    <a href="/business/create">
        <button>Create Business Profile</button>
    </a>

    <br><br>

    <a href="/business/profile">
        <button>My Business Profile</button>
    </a>

    <br><br>

    <a href="/dashboard">
        <button>Business Dashboard</button>
    </a>

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