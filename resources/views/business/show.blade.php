<!DOCTYPE html>
<html>
<head>
    <title>{{ $business->business_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="card border-0 shadow-sm rounded-5 mb-4">
        <div class="card-body p-5">
            <h1 class="display-5 fw-bold mb-3">{{ $business->business_name }}</h1>

            <p class="text-muted mb-2">
                <strong>Location:</strong> {{ $business->location }}
            </p>

            <p class="lead mb-0">
                {{ $business->description ?? 'No description available yet.' }}
            </p>

            <p class="text-muted mt-3 mb-0">
                <strong>Opening Hours:</strong>
                @if($business->opening_time && $business->closing_time)
                    {{ substr($business->opening_time, 0, 5) }} - {{ substr($business->closing_time, 0, 5) }}
                @else
                    Not available
                @endif
            </p>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Available Services</h2>

        <a href="/businesses" class="btn btn-outline-dark rounded-pill px-4">
            Back to Businesses
        </a>
    </div>

    @if($services->count() > 0)

        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4 d-flex flex-column">

                            <h3 class="h4 fw-bold">{{ $service->name }}</h3>

                            <p class="text-muted">
                                {{ $service->description }}
                            </p>

                            <div class="mt-auto">
                                <p class="mb-1">
                                    <strong>Price:</strong> &pound;{{ $service->price }}
                                </p>

                                <p class="mb-3">
                                    <strong>Duration:</strong> {{ $service->formattedDuration() }}
                                </p>

                                @auth
                                    @if(Auth::user()->role === 'customer')
                                        <a href="/book/{{ $service->id }}" class="btn btn-dark rounded-pill w-100">
                                            Book Service
                                        </a>
                                    @else
                                        <button class="btn btn-secondary rounded-pill w-100" disabled>
                                            Customer booking only
                                        </button>
                                    @endif
                                @else
                                    <a href="/login" class="btn btn-dark rounded-pill w-100">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <p class="mb-0">This business has not added any services yet.</p>
        </div>

    @endif

</div>

</body>
</html>
