<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
</head>
<body>

@include('partials.nav')

<h1>Edit {{ $service->name }}</h1>

<form method="POST" action="/services/{{ $service->id }}">
    @csrf
    @method('PUT')

    <label>Service Name:</label><br>
    <input type="text" name="name" value="{{ old('name', $service->name) }}" required><br><br>

    <label>Description:</label><br>
    <textarea name="description">{{ old('description', $service->description) }}</textarea><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" value="{{ old('price', $service->price) }}" required><br><br>

    <label>Duration in minutes:</label><br>
    <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>

<a href="/services">Back to Services</a>

</body>
</html>
