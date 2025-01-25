<?php

namespace App\Filament\Frontend\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use App\Models\Post;

class Homepage extends \Filament\Pages\Dashboard implements
    HasForms,
    HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    protected static string $view = "filament.frontend.pages.homepage";

    protected static ?string $title = 'I\'m Knight';

    protected static bool $shouldRegisterNavigation = false;

    public $record;

    public function mount(Post $record): void
    {
        $this->record = $record;
    }

    public function content(Infolist $infolist): Infolist
    {
        // dd($this->record->get()->toArray());
        return $infolist
            //->state(["posts" => $this->record->get()->toArray()])
            ->record($this->record)
            ->schema([
                Components\ViewEntry::make("posts")->view("livewire.content"),
                // Components\RepeatableEntry::make("posts")
                //     ->schema([
                //         Components\ViewEntry::make("title")->view(
                //             "livewire.content"
                //         ),
                //     ])
                //     ->contained(false)
                //     ->grid(3),
            ]);
    }
}
