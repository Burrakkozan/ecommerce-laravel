<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class UserChart extends LineChartWidget
{
    protected static ?string $heading = 'Users Trend use';

    protected static ?int $sort = 1;
    protected function getData(): array
    {
//        $users = User::select('created_at')->get()->groupBy(function($users) {
//            return Carbon::parse($users->created_at)->format('F');
//        });
//        $quantities = [];
//        foreach ($users as $user => $value) {
//            array_push($quantities, $value->count());
//        }
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
