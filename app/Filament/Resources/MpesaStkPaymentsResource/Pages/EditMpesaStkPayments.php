<?php

namespace App\Filament\Resources\MpesaStkPaymentsResource\Pages;

use App\Filament\Resources\MpesaStkPaymentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMpesaStkPayments extends EditRecord
{
    protected static string $resource = MpesaStkPaymentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
