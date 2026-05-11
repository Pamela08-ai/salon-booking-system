<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Salon Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <p><a href="/services">Services</a> | <a href="/bookings">Bookings</a></p>

                    <hr><br>

                    <h3>Total Bookings: {{ $totalBookings }}</h3>
                    <h3>Total Revenue (Deposits): £{{ $totalRevenue }}</h3>
                    <h3>Pending Bookings: {{ $pendingBookings }}</h3>
                    <h3>Cancelled Bookings: {{ $cancelledBookings }}</h3>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>