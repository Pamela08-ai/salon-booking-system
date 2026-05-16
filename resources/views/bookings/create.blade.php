<!DOCTYPE html>
<html>
<head>
    <title>Book Service</title>
</head>
<body>

@include('partials.nav')

<h1>Book {{ $service->name }}</h1>

<p>Price: &pound;{{ $service->price }}</p>
<p>Duration: {{ $service->formattedDuration() }}</p>
<p>Deposit Required: &pound;20</p>

<form method="POST" action="/book">
    @csrf

    <input type="hidden" name="service_id" value="{{ $service->id }}">

    <label>Date:</label><br>
    <input type="date" name="booking_date" required><br><br>

    <label>Time:</label><br>
    <input type="time" name="booking_time" required><br><br>

    <label>Staff Member:</label><br>
    <select name="staff_name" required>
        <option value="Alice">Alice</option>
        <option value="John">John</option>
        <option value="Mary">Mary</option>
    </select><br><br>

    <button type="submit">Book Now</button>
</form>

<br>
<a href="/businesses/{{ $service->business_id }}">Back to Business</a>

</body>
</html>
