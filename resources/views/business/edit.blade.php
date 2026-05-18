<!DOCTYPE html>
<html>
<head>
    <title>Edit Business Profile</title>
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
                        Edit Business Profile
                    </h1>

                    <p class="text-muted mb-4">
                        Update your business details and opening hours.
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

                    <form method="POST" action="/business">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Business Name
                            </label>

                            <input
                                type="text"
                                name="business_name"
                                class="form-control rounded-4"
                                value="{{ old('business_name', $business->business_name) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control rounded-4"
                                value="{{ old('location', $business->location) }}"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="5"
                                class="form-control rounded-4"
                            >{{ old('description', $business->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    Opening Time
                                </label>

                                <input
                                    type="time"
                                    name="opening_time"
                                    class="form-control rounded-4"
                                    value="{{ old('opening_time', $business->opening_time ? substr($business->opening_time, 0, 5) : '') }}"
                                >
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    Closing Time
                                </label>

                                <input
                                    type="time"
                                    name="closing_time"
                                    class="form-control rounded-4"
                                    value="{{ old('closing_time', $business->closing_time ? substr($business->closing_time, 0, 5) : '') }}"
                                >
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4">
                                Save Changes
                            </button>

                            <a href="/business/profile" class="btn btn-outline-dark btn-lg rounded-pill px-4">
                                Cancel
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
