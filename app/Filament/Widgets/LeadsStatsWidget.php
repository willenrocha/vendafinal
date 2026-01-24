<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Total de leads (pedidos não pagos)
        $totalLeads = Order::where('status', OrderStatus::AwaitingPayment)->count();

        // Leads não contatados
        $notContacted = Order::where('status', OrderStatus::AwaitingPayment)
            ->whereNull('contacted_at')
            ->count();

        // Leads contatados
        $contacted = Order::where('status', OrderStatus::AwaitingPayment)
            ->whereNotNull('contacted_at')
            ->count();

        // Taxa de conversão de contato
        $contactRate = $totalLeads > 0 ? round(($contacted / $totalLeads) * 100) : 0;

        // Leads de hoje
        $todayLeads = Order::where('status', OrderStatus::AwaitingPayment)
            ->whereDate('created_at', today())
            ->count();

        // Valor total em leads
        $leadsValue = Order::where('status', OrderStatus::AwaitingPayment)->sum('amount');

        return [
            Stat::make('Total de Leads', $totalLeads)
                ->description('Pedidos aguardando pagamento')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning')
                ->chart([
                    $totalLeads - 5,
                    $totalLeads - 3,
                    $totalLeads - 2,
                    $totalLeads - 1,
                    $totalLeads
                ]),

            Stat::make('Não Contatados', $notContacted)
                ->description('Necessitam contato urgente')
                ->descriptionIcon('heroicon-m-phone-arrow-up-right')
                ->color('danger'),

            Stat::make('Contatados', $contacted)
                ->description("{$contactRate}% de taxa de contato")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Valor em Leads', 'R$ ' . number_format($leadsValue / 100, 2, ',', '.'))
                ->description("{$todayLeads} novos hoje")
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),
        ];
    }
}
