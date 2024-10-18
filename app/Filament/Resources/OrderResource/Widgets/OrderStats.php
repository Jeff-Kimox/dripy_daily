<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{

    protected function formatNumber($number)
    {
        if ($number >= 1000000) {
            return Number::currency(round($number / 1000000, 2), 'KES') . 'M';
        } elseif ($number >= 1000) {
            return Number::currency(round($number / 1000, 2), 'KES') . 'K';
        }

        return Number::currency($number, 'KES');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),
            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),
            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),
            // Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total'), 'KES'))
            Stat::make('Average Price', $this->formatNumber(Order::query()->avg('grand_total'))),
        ];
    }
}
