<!DOCTYPE html>
<html>
<head>
    <title>Browse Businesses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">
    {{-- Customers and guests use this search to find salons by name, location, or service. --}}
    <form method="GET" action="/businesses" class="mb-5">
        <div class="row g-2">
            <div class="col-md-9">
                <input
                    type="text"
                    name="search"
                    class="form-control form-control-lg rounded-pill"
                    placeholder="Search by salon name, location, or service type..."
                    value="{{ $search ?? '' }}"
                >
            </div>

            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-dark btn-lg rounded-pill">
                    Search
                </button>
            </div>
        </div>

        @if(!empty($search))
            <div class="mt-3">
                <a href="/businesses" class="text-muted">
                    Clear search
                </a>
            </div>
        @endif
    </form>

    @if($businesses->count() > 0)

        {{-- Each card links to the public business page where active services are shown. --}}
        <div class="row g-4">
            @foreach($businesses as $business)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h2 class="h4 fw-bold">{{ $business->business_name }}</h2>

                            <p class="text-muted mb-2">
                                <strong>Location:</strong> {{ $business->location }}
                            </p>

                            <p>
                                {{ $business->description }}
                            </p>

                            <a href="/businesses/{{ $business->id }}" class="btn btn-dark rounded-pill px-4">
                                View Business
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="card border-0 shadow-sm rounded-4 p-4">
            @if(!empty($search))
                <p class="mb-0">
                    No businesses matched "{{ $search }}".
                </p>
            @else
                <p class="mb-0">No businesses available yet.</p>
            @endif
        </div>
    @endif
</div>

</body>
</html>
