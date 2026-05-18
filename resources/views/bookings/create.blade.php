<!DOCTYPE html>
<html>
<head>
    <title>Book Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-5">
                <div class="card-body p-5">

                    <h1 class="display-6 fw-bold mb-3">
                        Book {{ $service->name }}
                    </h1>

                    <div class="mb-4">
                        <p class="mb-1"><strong>Price:</strong> &pound;{{ $service->price }}</p>
                        <p class="mb-1"><strong>Duration:</strong> {{ $service->formattedDuration() }}</p>
                        <p class="mb-1">
                            <strong>Opening Hours:</strong>
                            @if($service->business->opening_time && $service->business->closing_time)
                                {{ substr($service->business->opening_time, 0, 5) }} - {{ substr($service->business->closing_time, 0, 5) }}
                            @else
                                Not set
                            @endif
                        </p>
                        <p class="mb-0"><strong>Deposit Required:</strong> &pound;20</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/book">
                        @csrf

                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Date</label>
                            <input type="date" name="booking_date" class="form-control rounded-4" value="{{ old('booking_date') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Time</label>
                            <input type="time" name="booking_time" class="form-control rounded-4" value="{{ old('booking_time') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Staff Member</label>
                            <select name="staff_name" class="form-select rounded-4" required>
                                <option value="Alice" @selected(old('staff_name') === 'Alice')>Alice</option>
                                <option value="John" @selected(old('staff_name') === 'John')>John</option>
                                <option value="Mary" @selected(old('staff_name') === 'Mary')>Mary</option>
                            </select>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4">
                                Book Now
                            </button>

                            <a href="/businesses/{{ $service->business_id }}" class="btn btn-outline-dark btn-lg rounded-pill px-4">
                                Back to Business
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
