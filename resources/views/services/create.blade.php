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

    <label>Duration (minutes):</label><br>
    <input type="number" name="duration"><br><br>

    <button type="submit">Add Service</button>
</form>

</body>
</html>