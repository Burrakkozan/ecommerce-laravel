<?php

namespace App\Filament\Resources;


use Akaunting\Money\View\Components\Currency;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Category;
use App\Models\Order;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;


    protected static ?string $navigationGroup = 'shop';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Address Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('city')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('zipcode')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('country')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('phone')
                                            ->tel()
                                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ])
                                ->columns(4),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('address')
                                            ->required()
                                            ->maxLength(255),

                                    ])
                                    ->columns(1),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('username')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->required()
                                            ->maxLength(255),

                                    ])
                                    ->columns(3),
                                MarkdownEditor::make('notes')
                                    ->placeholder('address Information')
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                        'codeBlock',
                                    ])
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'undo',
                                    ])
                                    ->required(),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(['lg' => 3]),


                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'Confirm' => 'Confirm',
                                        'Processing' => 'Processing',
                                        'Completed' => 'Completed',
                                        'Pending' => 'Pending',
                                    ])
                                    ->required(),

                                DateTimePicker::make('confirmed_date')
                                    ->label('Confirmed Date')
                                    ->default(now())
                                    ->required(),
                                Forms\Components\DatePicker::make('processing_date')
                                    ->label('Processing Date')
                                    ->default(now())
                                    ->required(),

                                DateTimePicker::make('delivered_date')
                                    ->label('Delivered Date')
                                    ->default(now())
                                    ->required(),

                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 3]),

                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Payment Information')
                            ->schema([
                                Forms\Components\TextInput::make('currency')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('amount')
                                    ->required(),
                                Forms\Components\TextInput::make('order_number')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('invoice_no')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('payment_method')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('order_date')
                                    ->label('Order Date')
                                    ->default(now())
                                    ->required(),


                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(['lg' => 3]),

            ])
            ->columns(1);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary'=> static fn ($state): bool => $state === 'Confirm',
                        'info' => static fn ($state): bool => $state === 'Pending',
                        'warning' => static fn ($state): bool => $state === 'Processing',
                        'success' => static fn ($state): bool => $state === 'Completed',
                    ]),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label('Order Date')
                    ->date()
                    ->toggleable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
