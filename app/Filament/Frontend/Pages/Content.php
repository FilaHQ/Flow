<?php

namespace App\Filament\Frontend\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use App\Models\Post;
use Filament\Support\Enums\MaxWidth;

class Content extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    protected static string $view = "filament.frontend.pages.content";

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = "{slug}";

    public $record;

    public function mount(Post $post, $slug): void
    {
        $this->record = $post->whereSlug($slug)->firstOrFail();
    }

    public function getTitle(): string
    {
        return $this->record->title;
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::FiveExtraLarge;
    }

    public function content(Infolist $infolist): Infolist
    {
        return $infolist->record($this->record)->schema([
            Components\ImageEntry::make("cover_image")
                ->extraImgAttributes([
                    "class" => "w-full",
                    "style" => "height:auto",
                ])

                ->label("")
                ->columnSpanFull(),
            Components\TextEntry::make("content")
                ->label("")
                ->size(Components\TextEntry\TextEntrySize::Large)
                ->markdown(),
        ]);
    }
}
