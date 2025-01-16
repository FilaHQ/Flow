<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make("title")
                            ->label("Post Title")
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

                        Forms\Components\TextInput::make("slug")
                            ->label("Slug")
                            ->required()
                            ->unique(
                                Post::class,
                                "slug",
                                fn($record) => $record
                            ),
                        Forms\Components\RichEditor::make("content")
                            ->label("Content")
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        "sm" => 2,
                    ])
                    ->columnSpan(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make(
                            "published_at"
                        )->label("Publish Date"),
                        Forms\Components\Placeholder::make("created_at")
                            ->label("Created Date")
                            ->content(
                                fn(?Post $record): string => $record
                                    ? $record->created_at->diffForHumans()
                                    : "-"
                            ),
                        Forms\Components\Placeholder::make("updated_at")
                            ->label("Last Modified Date")
                            ->content(
                                fn(?Post $record): string => $record
                                    ? $record->updated_at->diffForHumans()
                                    : "-"
                            ),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->label(__("Title"))
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                Tables\Columns\TextColumn::make("published_at")
                    ->label("Published At")
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make("published_at")
                    ->form([
                        Forms\Components\DatePicker::make(
                            "published_from"
                        )->placeholder(
                            fn($state): string => "Dec 18, " .
                                now()->subYear()->format("Y")
                        ),
                        Forms\Components\DatePicker::make(
                            "published_until"
                        )->placeholder(
                            fn($state): string => now()->format("M d, Y")
                        ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data["published_from"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "published_at",
                                    ">=",
                                    $date
                                )
                            )
                            ->when(
                                $data["published_until"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "published_at",
                                    "<=",
                                    $date
                                )
                            );
                    }),
            ])
            ->defaultSort("published_at", "desc")
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            "index" => Pages\ListPosts::route("/"),
            "create" => Pages\CreatePost::route("/create"),
            "edit" => Pages\EditPost::route("/{record}/edit"),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
