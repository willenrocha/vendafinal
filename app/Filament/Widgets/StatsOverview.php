<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Models\Package;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Pedidos de hoje
        $todayOrders = Order::whereDate('created_at', today())->count();
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $todayChange = $yesterdayOrders > 0
            ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100)
            : 0;

        // Receita total
        $totalRevenue = Order::where('status', OrderStatus::Paid)->sum('amount');
        $monthRevenue = Order::where('status', OrderStatus::Paid)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');
        $lastMonthRevenue = Order::where('status', OrderStatus::Paid)
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->sum('amount');
        $revenueChange = $lastMonthRevenue > 0
            ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : 0;

        // Pedidos pendentes
        $pendingOrders = Order::where('status', OrderStatus::AwaitingPayment)->count();

        // Total de clientes
        $totalCustomers = User::where('is_admin', false)->count();
        $monthCustomers = User::where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->count();

        return [
            Stat::make('Pedidos Hoje', $todayOrders)
                ->description($todayChange >= 0 ? "+{$todayChange}% vs ontem" : "{$todayChange}% vs ontem")
                ->descriptionIcon($todayChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($todayChange >= 0 ? 'success' : 'danger')
                ->chart([7, 4, 6, 8, 10, 12, $todayOrders]),

            Stat::make('Receita Total', 'R$ ' . Number::format($totalRevenue, locale: 'pt-BR'))
                ->description($revenueChange >= 0 ? "+{$revenueChange}% este mês" : "{$revenueChange}% este mês")
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart([
                    $lastMonthRevenue > 0 ? $lastMonthRevenue : 0,
                    $monthRevenue > 0 ? $monthRevenue : 0
                ]),

            Stat::make('Pedidos Pendentes', $pendingOrders)
                ->description('Aguardando pagamento')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Total de Clientes', $totalCustomers)
                ->description("{$monthCustomers} novos este mês")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }
}
