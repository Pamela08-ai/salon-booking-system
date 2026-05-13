<!DOCTYPE html>
<html>
<head>
    <title>Create Business Profile</title>
</head>
<body>

<h1>Create Your Business Profile</h1>

<form method="POST" action="/business">
    @csrf

    <label>Business Name:</label><br>
    <input type="text" name="business_name" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Save Business Profile</button>
</form>

</body>
</html>