<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MpesaStkPaymentsResource\Pages;
use App\Filament\Resources\MpesaStkPaymentsResource\RelationManagers;
use App\Models\MpesaStkPayments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MpesaStkPaymentsResource extends Resource
{
    protected static ?string $model = MpesaStkPayments::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'M-Pesa';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('merchant_request_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('checkout_request_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_shortcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('msisdn')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMpesaStkPayments::route('/'),
            // 'create' => Pages\CreateMpesaStkPayments::route('/create'),
            // 'edit' => Pages\EditMpesaStkPayments::route('/{record}/edit'),
        ];
    }
}
