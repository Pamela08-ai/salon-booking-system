<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="/">
            Bookira
        </a>

        <button class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <div class="ms-auto d-flex flex-column flex-lg-row gap-3 align-items-lg-center mt-3 mt-lg-0">

                <a class="nav-link" href="/">Home</a>

                @guest

                    <a class="nav-link" href="/businesses">
                        Book Appointment
                    </a>

                    <a class="btn btn-outline-dark rounded-pill px-4"
                       href="/login">
                        Login
                    </a>

                    <a class="btn btn-dark rounded-pill px-4"
                       href="/register">
                        Register
                    </a>

                @endguest

                @auth

                    @if(Auth::user()->role === 'customer')

                        <a class="nav-link" href="/businesses">
                            Book Appointment
                        </a>

                        <a class="nav-link" href="/my-bookings">
                            My Appointments
                        </a>

                    @endif

                    @if(Auth::user()->role === 'business_owner')

                        <a class="nav-link" href="/business/profile">
                            My Business
                        </a>

                        <a class="nav-link" href="/services">
                            Manage Services
                        </a>

                        <a class="nav-link" href="/bookings">
                            Manage Bookings
                        </a>

                        <a class="nav-link" href="/dashboard">
                            Dashboard
                        </a>

                    @endif

                    <form method="POST" action="/logout">
                        @csrf

                        <button type="submit"
                                class="btn btn-dark rounded-pill px-4">
                            Logout
                        </button>
                    </form>

                @endauth

            </div>

        </div>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>