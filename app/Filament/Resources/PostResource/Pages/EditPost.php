<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taxonomy;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $terms = $this->record->taxos()->get();
        foreach ($terms as $term) {
            $data[$term->taxo->slug][] = $term->id;
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

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
