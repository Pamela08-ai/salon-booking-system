<!DOCTYPE html>
<html>
<head>
    <title>Services</title>
</head>
<body>

<h1>Salon Services</h1>

<a href="/services/create">Add New Service</a>

<br><br>

@if($services->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Action</th>
        </tr>

        @foreach($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->description }}</td>
                <td>£{{ $service->price }}</td>
                <td>{{ $service->duration }} minutes</td>
                <td>
                    <a href="/book/{{ $service->id }}">Book</a>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>No services added yet.</p>
@endif

</body>
</html>