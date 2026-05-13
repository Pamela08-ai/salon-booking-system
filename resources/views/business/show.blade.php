<!DOCTYPE html>
<html>
<head>
    <title>{{ $business->business_name }}</title>
</head>
<body>

<h1>{{ $business->business_name }}</h1>

<p>
    <strong>Location:</strong>
    {{ $business->location }}
</p>

<p>
    {{ $business->description }}
</p>

<hr>

<h2>Available Services</h2>

@if($services->count() > 0)
    <table border="1" cellpadding="10">
        <tr>
            <th>Service</th>
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
                    <a href="/book/{{ $service->id }}">
                        <button>Book Service</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>This business has not added any services yet.</p>
@endif

<p>
    Services for this business will appear here.
</p>

<br>

<a href="/services">
    <button>View Services</button>
</a>

<br><br>

<a href="/businesses">
    Back to Businesses
</a>

</body>
</html>