<?php

namespace App\Filament\Resources\TaxonomyResource\Pages;

use App\Filament\Resources\TaxonomyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaxonomy extends CreateRecord
{
    protected static string $resource = TaxonomyResource::class;
}
