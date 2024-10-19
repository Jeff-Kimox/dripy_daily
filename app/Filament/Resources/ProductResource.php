<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            } ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        Forms\Components\MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products'),
                    ])->columns(2),

                    Section::make('Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable(),
                    ])

                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('KES'),
                        Forms\Components\TextInput::make('price_discount')
                            ->numeric()
                            ->prefix('KES'),
                    ]),

                    Section::make('Association')->schema([
                        Forms\Components\Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name'),
                        Forms\Components\Select::make('brand_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('brand', 'name'),
                    ]),

                    Section::make('Status')->schema([
                        Forms\Components\Toggle::make('in_stock')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->required(),
                        Forms\Components\Toggle::make('on_sale')
                            ->required(),
                    ])
                ])->columnSpan(1)
            ])->columns(3);
            // ->schema([
            //     Forms\Components\TextInput::make('category_id')
            //         ->required()
            //         ->numeric(),
            //     Forms\Components\TextInput::make('brand_id')
            //         ->required()
            //         ->numeric(),
            //     Forms\Components\TextInput::make('name')
            //         ->required()
            //         ->maxLength(255),
            //     Forms\Components\TextInput::make('slug')
            //         ->required()
            //         ->maxLength(255),
            //     Forms\Components\Textarea::make('description')
            //         ->columnSpanFull(),
            //     Forms\Components\Textarea::make('images')
            //         ->columnSpanFull(),
            //     Forms\Components\TextInput::make('price')
            //         ->required()
            //         ->numeric()
            //         ->prefix('$'),
            //     Forms\Components\TextInput::make('price_discount')
            //         ->required()
            //         ->numeric(),
            //     Forms\Components\Toggle::make('is_active')
            //         ->required(),
            //     Forms\Components\Toggle::make('is_featured')
            //         ->required(),
            //     Forms\Components\Toggle::make('in_stock')
            //         ->required(),
            //     Forms\Components\Toggle::make('on_sale')
            //         ->required(),
            // ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([             
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('slug')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('KES')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_discount')
                    ->money('KES')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),               
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
