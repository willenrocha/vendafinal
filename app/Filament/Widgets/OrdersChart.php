<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OrdersChart extends ChartWidget
{
    protected ?string $heading = 'Pedidos nos Últimos 7 Dias';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'half';

    protected function getData(): array
    {
        $data = $this->getOrdersPerDay();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos Pagos',
                    'data' => $data['paid'],
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Pedidos Pendentes',
                    'data' => $data['pending'],
                    'backgroundColor' => 'rgba(249, 115, 22, 0.2)',
                    'borderColor' => 'rgb(249, 115, 22)',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersPerDay(): array
    {
        $days = collect();
        $paid = [];
        $pending = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $paidCount = Order::where('status', OrderStatus::Paid)
                ->whereDate('created_at', $date)
                ->count();

            $pendingCount = Order::where('status', OrderStatus::AwaitingPayment)
                ->whereDate('created_at', $date)
                ->count();

            $paid[] = $paidCount;
            $pending[] = $pendingCount;
            $labels[] = $date->format('d/m');
        }

        return [
            'paid' => $paid,
            'pending' => $pending,
            'labels' => $labels,
        ];
    }
}
