<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Business;
use Carbon\Carbon;

class DecisionSupportService
{
    public function analyse(Business $business): array
    {
        // Get all bookings linked to this business so the dashboard only uses the owner's own data.
        $bookings = Booking::with('service')
            ->whereHas('service', function ($query) use ($business) {
                $query->where('business_id', $business->id);
            })
            ->get();

        $totalBookings = $bookings->count();
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();
        $unpaidDeposits = $bookings
            ->where('deposit_paid', false)
            ->where('status', '!=', 'cancelled')
            ->count();

        $cancellationRate = $totalBookings > 0
            ? round(($cancelledBookings / $totalBookings) * 100, 1)
            : 0;

        $recentBookings = $bookings->filter(function ($booking) {
            return $booking->created_at && $booking->created_at->gte(now()->subDays(30));
        })->count();

        // This is a simple forecast, not a trained AI model. It estimates next week from recent bookings.
        $forecastNextWeek = max(0, (int) round(($recentBookings / 30) * 7));

        $busiestDay = $this->busiestDay($bookings);
        $demandLevel = $this->demandLevel($forecastNextWeek);
        $riskLevel = $this->riskLevel($cancellationRate, $unpaidDeposits);
        $recommendations = $this->recommendations(
            $forecastNextWeek,
            $cancellationRate,
            $unpaidDeposits,
            $busiestDay
        );

        return [
            'forecast_next_week' => $forecastNextWeek,
            'demand_level' => $demandLevel,
            'risk_level' => $riskLevel,
            'busiest_day' => $busiestDay,
            'recommendations' => $recommendations,
        ];
    }

    private function busiestDay($bookings): ?string
    {
        // Group bookings by weekday so the owner can see which day is usually busiest.
        $days = $bookings
            ->filter(fn ($booking) => !empty($booking->booking_date))
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->booking_date)->format('l');
            })
            ->map
            ->count()
            ->sortDesc();

        return $days->isEmpty() ? null : $days->keys()->first();
    }

    private function demandLevel(int $forecastNextWeek): string
    {
        if ($forecastNextWeek >= 10) {
            return 'High';
        }

        if ($forecastNextWeek >= 4) {
            return 'Medium';
        }

        return 'Low';
    }

    private function riskLevel(float $cancellationRate, int $unpaidDeposits): string
    {
        // Risk is based on two things that can affect the business: cancellations and unpaid deposits.
        if ($cancellationRate >= 40 || $unpaidDeposits >= 5) {
            return 'High';
        }

        if ($cancellationRate >= 20 || $unpaidDeposits >= 2) {
            return 'Medium';
        }

        return 'Low';
    }

    private function recommendations(
        int $forecastNextWeek,
        float $cancellationRate,
        int $unpaidDeposits,
        ?string $busiestDay
    ): array {
        $recommendations = [];

        // These messages are the decision-support part of the dashboard.
        if ($forecastNextWeek > 0) {
            $recommendations[] = 'Expected bookings next week: about ' . $forecastNextWeek . '.';
        } else {
            $recommendations[] = 'Not enough recent bookings yet to forecast demand accurately.';
        }

        if ($busiestDay) {
            $recommendations[] = $busiestDay . ' is currently the busiest booking day. Consider preparing more staff availability on that day.';
        }

        if ($cancellationRate >= 20) {
            $recommendations[] = 'Cancellation rate is above 20%. Consider encouraging deposits or clearer cancellation policies.';
        }

        if ($unpaidDeposits > 0) {
            $recommendations[] = $unpaidDeposits . ' active bookings still have unpaid deposits. Follow-up reminders may reduce no-shows.';
        }

        if (count($recommendations) === 1 && $forecastNextWeek === 0) {
            $recommendations[] = 'As more bookings are added, the system will provide stronger decision-support insights.';
        }

        return $recommendations;
    }
}
