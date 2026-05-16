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

                    @if(!$business)

                        <h2>Create Your Business Profile</h2>

                        <p>
                            You need to create a business profile before adding services or viewing business analytics.
                        </p>

                        <a href="/business/create">
                            <button>Create Business Profile</button>
                        </a>

                        <hr><br>

                    @else

                        <h2>{{ $business->business_name }} Dashboard</h2>

                        <hr><br>

                    @endif

                    <p><a href="/services">Services</a> | <a href="/bookings">Bookings</a></p>

                    <hr><br>

                    <h3>Total Bookings: {{ $totalBookings }}</h3>
                    <h3>Total Revenue (Deposits): &pound;{{ $totalRevenue }}</h3>
                    <h3>Pending Bookings: {{ $pendingBookings }}</h3>
                    <h3>Cancelled Bookings: {{ $cancelledBookings }}</h3>
                    <h3>Completed Bookings: {{ $completedBookings }}</h3>
                    <h3>Unpaid Active Deposits: {{ $totalUnpaidDeposits }}</h3>
                    <h3>Cancellation Rate: {{ $cancellationRate }}%</h3>

                    @if($mostBookedStaff)
                        <h3>Most Booked Staff: {{ $mostBookedStaff->staff_name }}</h3>
                    @else
                        <h3>Most Booked Staff: No staff data yet</h3>
                    @endif

                    <br><br>

                    @if($popularService)
                        <h3>Most Popular Service: {{ $popularService->service->name }}</h3>
                    @else
                        <h3>No bookings yet</h3>
                    @endif

                    <br><br>

                    <h3>Business Insights</h3>

                    <ul>
                        @if($cancellationRate > 50)
                            <li>High cancellation rate detected. Consider reviewing cancellation policies or deposit rules.</li>
                        @endif

                        @if($totalUnpaidDeposits > 0)
                            <li>{{ $totalUnpaidDeposits }} active bookings have unpaid deposits. Follow-up reminders may reduce no-shows.</li>
                        @endif

                        @if($popularService)
                            <li>{{ $popularService->service->name }} is currently the most popular service. Consider promoting this service or allocating more staff time to it.</li>
                        @endif

                        @if($mostBookedStaff)
                            <li>{{ $mostBookedStaff->staff_name }} has the highest number of bookings. This may help with staff scheduling decisions.</li>
                        @endif
                    </ul>

                    <br><br>
                    <canvas id="bookingChart" width="400" height="200"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const ctx = document.getElementById('bookingChart').getContext('2d');

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Total', 'Pending', 'Cancelled', 'Completed'],
                                datasets: [{
                                    label: 'Bookings Overview',
                                    data: [
                                        {{ $totalBookings }},
                                        {{ $pendingBookings }},
                                        {{ $cancelledBookings }},
                                        {{ $completedBookings }}
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
