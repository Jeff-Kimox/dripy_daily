<?php

namespace App\Filament\Resources\MpesaStkPaymentsResource\Pages;

use App\Filament\Resources\MpesaStkPaymentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMpesaStkPayments extends ListRecords
{
    protected static string $resource = MpesaStkPaymentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
