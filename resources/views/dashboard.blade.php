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

                    <br><br>

                    @if($popularService)
                        <h3>Most Popular Service: {{ $popularService->service->name }}</h3>
                    @else
                        <h3>No bookings yet</h3>
                    @endif
                    
                    <br><br>
                    <canvas id="bookingChart" width="400" height="200"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const ctx = document.getElementById('bookingChart').getContext('2d');

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Total', 'Pending', 'Cancelled'],
                                datasets: [{
                                    label: 'Bookings Overview',
                                    data: [
                                        {{ $totalBookings }},
                                        {{ $pendingBookings }},
                                        {{ $cancelledBookings }}
                                    ],
                                    borderWidth: 1
                                }]
                            }
                        });
                    </script>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>