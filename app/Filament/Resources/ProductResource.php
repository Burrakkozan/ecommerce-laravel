<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Callable_;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-bag';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Section attribute')
                            ->schema([
                                Forms\Components\Checkbox::make('hot_deals')
                                    ->label('Hot Deals'),

                                Forms\Components\Checkbox::make('featured')
                                    ->label('Featured'),

                                Forms\Components\Checkbox::make('special_offer')
                                    ->label('Special Offer'),

                                Forms\Components\Checkbox::make('special_deals')
                                    ->label('Special Deals'),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(['lg' => 1]),


                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Visible')
                                    ->helperText('This product will be hidden from all sales channels.')
                                    ->default(true),
                                Forms\Components\DatePicker::make('created_at')
                                    ->label('Availability')
                                    ->default(now())
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),

                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Color & Size')
                            ->schema([
                                TagsInput::make('product_color')->separator(',')
                               ->helperText('Type and add a new color tag.'),
                                 TagsInput::make('product_size')->separator(',')
                                ->helperText('Type and add a new size tag.'),


//                                Select::make('product_color')
//                                    ->multiple()
//                                    ->options([
//                                        'White' => 'White',
//                                        'blue' => 'blue',
//                                        'black' => 'black',
//                                    ]),
//                                Select::make('product_size')
//                                    ->multiple()
//                                    ->options([
//                                        'M' => 'M',
//                                        'L' => 'L',
//                                        'S' => 'S',
//                                    ])
                            ])


                    ])
                    ->columnSpan(['lg' => 1]),


                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Pricing')
                            ->schema([
                                Forms\Components\TextInput::make('selling_price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                                Forms\Components\TextInput::make('discount_price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                                Forms\Components\TextInput::make('product_qty')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 1]),

                Card::make()
                    ->schema([
                        Forms\Components\Section::make('Category')
                            ->schema([

//                                Select::make('category_id')
//                                    ->label('Category')
//                                    ->options(Category::all()->pluck('category_name', 'id'))
//                                    ->required(),
//                                Select::make('subcategory_id')
//                                    ->label('Sub Category')
//                                    ->options(SubCategory::all()->pluck('subcategory_name', 'id'))
//                                    ->required(),

                            Select::make('category_id')
                                ->label('Category')
                                ->options(Category::all()->pluck('category_name', 'id')->toArray())
                                ->reactive()
                                ->required()
                                 ->afterStateUpdated(fn (callable $set) => $set('subcategory_id', null)),

                            Select::make('subcategory_id')
                                ->label('Sub Category')
                                ->options(function (callable $get) {
                                    $category = Category::find($get('category_id'));
                                    if(!$category) {
                                        return SubCategory::all()->pluck('subcategory_name', 'id');
                                    }
                                    return $category->subcategory->pluck('subcategory_name', 'id');
                            })
                                ->helperText('first select category name then select subcategory name')

                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                card::make()
                    ->schema([
                        Forms\Components\Section::make('Product Information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('product_name')
                                            ->placeholder('Name')
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $set('slug', Str::slug($state));
                                            }),
                                        TextInput::make('slug')->disabled()->required(),
                                    ]),
                                MarkdownEditor::make('product_detail')
                                    ->placeholder('product detail')
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

                        Card::make()
                            ->schema([
                                Forms\Components\FileUpload::make('image')->disk('public')->required()
                                    ->label('Main Image')
                                    ->maxSize(3072)
                                    ->helperText('This image size should be 250x250 for better solution')
                                    ->image()
                                    ->required(),
                                Forms\Components\FileUpload::make('alt_image')->disk('public')->required()
                                    ->label('Alternate Images')
                                    ->maxSize(3072)
                                    ->image()
                                    ->nullable()
                                    ->maxFiles(5)
                                    ->multiple(),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(['lg' => 2]),


            ])
            ->columns(2);

    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->disk('public'),
                TextColumn::make('category.category_name')->sortable()->searchable(),
                TextColumn::make('subcategory.subcategory_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('product_detail')->limit(50),
                Tables\Columns\TextColumn::make('product_size'),
                Tables\Columns\TextColumn::make('product_color'),
                Tables\Columns\IconColumn::make('hot_deals')
                    ->boolean(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('special_offer')
                    ->boolean(),
                Tables\Columns\IconColumn::make('special_deals')
                    ->boolean(),
                Tables\Columns\TextColumn::make('discount_price'),
                Tables\Columns\TextColumn::make('selling_price'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Active'),
                Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false))
                    ->label(' inActive'),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
