<!DOCTYPE html>
<html>
<head>
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: #f7f5ff; min-height: 100vh;">

@include('partials.nav')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1">Manage Services</h1>
            <p class="text-muted mb-0">Add, edit, or deactivate services offered by your business.</p>
        </div>

        <a href="/services/create" class="btn btn-dark rounded-pill px-4">
            Add New Service
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">
            {{ session('success') }}
        </div>
    @endif

    @if($services->count() > 0)

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3">Name</th>
                            <th class="p-3">Description</th>
                            <th class="p-3">Price</th>
                            <th class="p-3">Duration</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="p-3 fw-semibold">{{ $service->name }}</td>
                                <td class="p-3 text-muted">{{ $service->description }}</td>
                                <td class="p-3">&pound;{{ $service->price }}</td>
                                <td class="p-3">{{ $service->formattedDuration() }}</td>

                                <td class="p-3">
                                    @if($service->is_active)
                                        <span class="badge rounded-pill text-bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <a href="/services/{{ $service->id }}/edit" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                        Edit
                                    </a>

                                    @if($service->is_active)
                                        <form method="POST" action="/services/{{ $service->id }}/deactivate" class="d-inline">
                                            @csrf

                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted ms-2">Deactivated</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else

        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <h2 class="h4 fw-bold">No services added yet</h2>
            <p class="text-muted">Create your first service so customers can start booking appointments.</p>

            <a href="/services/create" class="btn btn-dark rounded-pill px-4">
                Add Service
            </a>
        </div>

    @endif

</div>

</body>
</html>