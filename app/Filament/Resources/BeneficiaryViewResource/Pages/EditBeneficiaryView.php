<?php

namespace App\Filament\Resources\BeneficiaryViewResource\Pages;

use App\Filament\Resources\BeneficiaryViewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiaryView extends EditRecord
{
    protected static string $resource = BeneficiaryViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
