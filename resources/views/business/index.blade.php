<!DOCTYPE html>
<html>
<head>
    <title>Browse Businesses</title>
</head>
<body>

<h1>Browse Salon Businesses</h1>

<p>
    <a href="/">Home</a>
</p>

@if($businesses->count() > 0)

    @foreach($businesses as $business)
        <div style="border:1px solid black; padding:15px; margin-bottom:20px;">
            <h2>{{ $business->business_name }}</h2>
            <p><strong>Location:</strong> {{ $business->location }}</p>
            <p>{{ $business->description }}</p>
            <a href="/businesses/{{ $business->id }}">
                <button>View Business</button>
            </a>
        </div>
    @endforeach

@else
    <p>No businesses available yet.</p>
@endif

</body>
</html>