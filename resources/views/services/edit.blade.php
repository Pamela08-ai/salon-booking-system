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

    <label>Duration:</label><br>
    <input type="number" name="duration_hours" min="0" value="{{ old('duration_hours', intdiv($service->duration, 60)) }}"> hours
    <input type="number" name="duration_minutes" min="0" max="59" value="{{ old('duration_minutes', $service->duration % 60) }}"> minutes
    <br><br>

    <button type="submit">Save Changes</button>
</form>

<br>

<a href="/services">Back to Services</a>

</body>
</html>
