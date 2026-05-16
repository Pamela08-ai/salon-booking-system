<!DOCTYPE html>
<html>
<head>
    <title>Add Service</title>
</head>
<body>

@include('partials.nav')

<h1>Add Service</h1>

<form action="/services" method="POST">
    @csrf

    <label>Service Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price"><br><br>

    <label>Duration:</label><br>
    <input type="number" name="duration_hours" min="0" value="{{ old('duration_hours', 0) }}"> hours
    <input type="number" name="duration_minutes" min="0" max="59" value="{{ old('duration_minutes', 0) }}"> minutes
    <br><br>

    <button type="submit">Add Service</button>
</form>

</body>
</html>
