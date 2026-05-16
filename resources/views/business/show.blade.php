<!DOCTYPE html>
<html>
<head>
    <title>{{ $business->business_name }}</title>
</head>
<body>

@include('partials.nav')

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
                <td>&pound;{{ $service->price }}</td>
                <td>{{ $service->formattedDuration() }}</td>
                <td>
                    @auth
                        @if(Auth::user()->role === 'customer')
                            <a href="/book/{{ $service->id }}">
                                <button>Book Service</button>
                            </a>
                        @else
                            Customer booking only
                        @endif
                    @else
                        <a href="/login">
                            <button>Login to Book</button>
                        </a>
                    @endauth
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>This business has not added any services yet.</p>
@endif

<a href="/businesses">
    Back to Businesses
</a>

</body>
</html>
