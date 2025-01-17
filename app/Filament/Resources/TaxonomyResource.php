<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonomyResource\Pages;
use App\Filament\Resources\TaxonomyResource\RelationManagers;
use App\Models\Taxonomy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TaxonomyResource extends Resource
{
    protected static ?string $model = Taxonomy::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("name")
                ->required()
                ->live(debounce: 500)
                ->afterStateUpdated(function (
                    Get $get,
                    Set $set,
                    ?string $old,
                    ?string $state
                ) {
                    if (($get("slug") ?? "") !== Str::slug($old)) {
                        return;
                    }

                    $set("slug", Str::slug($state));
                }),
            Forms\Components\Select::make("type")
                ->options([
                    "dropdown" => "Dropdown",
                    "checkbox" => "Checkbox",
                    "tags" => "Tags",
                ])
                ->required(),
            Forms\Components\TextInput::make("slug")->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable(),
                Tables\Columns\TextColumn::make("type")->searchable(),
                Tables\Columns\TextColumn::make("slug")->searchable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [RelationManagers\TermsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTaxonomies::route("/"),
            "create" => Pages\CreateTaxonomy::route("/create"),
            "edit" => Pages\EditTaxonomy::route("/{record}/edit"),
        ];
    }
}
