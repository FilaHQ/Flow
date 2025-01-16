<?php

namespace App\Filament\Resources\TaxonomyResource\Pages;

use App\Filament\Resources\TaxonomyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxonomy extends EditRecord
{
    protected static string $resource = TaxonomyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
