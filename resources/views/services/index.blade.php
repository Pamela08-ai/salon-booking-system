<!DOCTYPE html>
<html>
<head>
    <title>Services</title>
</head>
<body>

@include('partials.nav')

<h1>Manage Services</h1>

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
                <td>&pound;{{ $service->price }}</td>
                <td>{{ $service->duration }} minutes</td>
                <td>
                    <a href="/services/{{ $service->id }}/edit">
                        <button>Edit Service</button>
                    </a>

                    <br><br>

                    <form method="POST" action="/services/{{ $service->id }}/deactivate">
                        @csrf

                        <button type="submit">Deactivate Service</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>No services added yet.</p>
@endif

</body>
</html>
