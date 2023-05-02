<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableQuery(): Builder
    {
        return OrderResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_date')
                ->label('Order Date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('order_number')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'secondary'=> static fn ($state): bool => $state === 'Confirm',
                    'info' => static fn ($state): bool => $state === 'Pending',
                    'warning' => static fn ($state): bool => $state === 'Processing',
                    'success' => static fn ($state): bool => $state === 'Completed',
                ]),
            Tables\Columns\TextColumn::make('currency')
                ->getStateUsing(fn (Order $record): string => $record->currency)
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('amount')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('invoice_no')
                ->label('Invoice No.')
                ->searchable()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('open')
                ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
