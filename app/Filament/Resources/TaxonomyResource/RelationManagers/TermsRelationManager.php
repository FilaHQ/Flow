<?php

namespace App\Filament\Resources\TaxonomyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TermsRelationManager extends RelationManager
{
    protected static string $relationship = "terms";

    public function form(Form $form): Form
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
            Forms\Components\TextInput::make("slug")->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("name")
            ->columns([Tables\Columns\TextColumn::make("name")])
            ->filters([
                //
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
