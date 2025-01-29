<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        $taxonomies = Taxonomy::whereHas("terms")->get();
        $terms = [];
        foreach ($taxonomies as $taxo) {
            if ($data[$taxo->slug]) {
                $add_term = is_array($data[$taxo->slug])
                    ? $data[$taxo->slug]
                    : [$data[$taxo->slug]];
                $terms = array_merge($terms, $add_term);
            }
        }
        $record->taxos()->sync($terms);
        return $record;
    }
}
