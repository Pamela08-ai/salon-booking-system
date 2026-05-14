<!DOCTYPE html>
<html>
<head>
    <title>My Business Profile</title>
</head>
<body>

@include('partials.nav')

@if($business)

    <h1>{{ $business->business_name }}</h1>

    <p>
        <strong>Location:</strong>
        {{ $business->location }}
    </p>

    <p>
        {{ $business->description }}
    </p>

    <hr><br>

    <h2>Business Management</h2>

    <a href="/services/create">
        <button>Add Service</button>
    </a>

    <br><br>

    <a href="/services">
        <button>Manage Services</button>
    </a>

    <br><br>

    <a href="/bookings">
        <button>Manage Bookings</button>
    </a>

    <br><br>

    <a href="/dashboard">
        <button>View Dashboard</button>
    </a>

    <br><br>

    <a href="/businesses/{{ $business->id }}">
        <button>View Public Business Page</button>
    </a>

@else

    <h1>No Business Profile Found</h1>

    <a href="/business/create">
        <button>Create Business Profile</button>
    </a>

@endif

<br><br><hr><br>

<a href="/">Back Home</a>

</body>
</html>