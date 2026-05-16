<nav style="padding: 15px; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
    @auth
        <p>Current role: {{ Auth::user()->role }}</p>
    @endauth

    <strong>Bookira</strong>
    <a href="/">Home</a>

    @guest
        <a href="/businesses">Book Appointment</a>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endguest


    @auth
        @if(Auth::user()->role === 'customer')
            <a href="/businesses">Book Appointment</a>
            <a href="/my-bookings">My Appointments</a>
        @endif

        @if(Auth::user()->role === 'business_owner')
            <a href="/business/profile">My Business</a>
            <a href="/services">Manage Services</a>
            <a href="/bookings">Manage Bookings</a>
            <a href="/dashboard">Dashboard</a>
        @endif

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth

    
</nav>