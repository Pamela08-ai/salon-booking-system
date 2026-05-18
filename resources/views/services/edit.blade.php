<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-5">
                <div class="card-body p-5">

                    <h1 class="display-6 fw-bold mb-2">
                        Edit {{ $service->name }}
                    </h1>

                    <p class="text-muted mb-4">
                        Update the service details shown to customers.
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/services/{{ $service->id }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Service Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control rounded-4"
                                value="{{ old('name', $service->name) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control rounded-4"
                            >{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Price (£)
                            </label>

                            <input
                                type="number"
                                name="price"
                                step="0.01"
                                class="form-control rounded-4"
                                value="{{ old('price', $service->price) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">
                                Duration
                            </label>

                            <div class="row">
                                <div class="col">
                                    <input
                                        type="number"
                                        name="duration_hours"
                                        min="0"
                                        class="form-control rounded-4"
                                        value="{{ old('duration_hours', intdiv($service->duration, 60)) }}"
                                    >

                                    <small class="text-muted">Hours</small>
                                </div>

                                <div class="col">
                                    <input
                                        type="number"
                                        name="duration_minutes"
                                        min="0"
                                        max="59"
                                        class="form-control rounded-4"
                                        value="{{ old('duration_minutes', $service->duration % 60) }}"
                                    >

                                    <small class="text-muted">Minutes</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4">
                                Save Changes
                            </button>

                            <a href="/services" class="btn btn-outline-dark btn-lg rounded-pill px-4">
                                Back to Services
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