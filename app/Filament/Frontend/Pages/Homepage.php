<?php

namespace App\Filament\Frontend\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use App\Models\Post;
use Livewire\WithPagination;

class Homepage extends \Filament\Pages\Dashboard implements
    HasForms,
    HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    use WithPagination;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    protected static string $view = "filament.frontend.pages.homepage";

    protected static ?string $title = 'I\'m Knight';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return config("flow.site.default.name");
    }

    public function getHeading(): string
    {
        return config("flow.site.default.name");
    }

    public function getSubheading(): ?string
    {
        return config("flow.site.default.description");
    }

    protected function getViewData(): array
    {
        return [
            "posts" => Post::query()->simplePaginate(
                config("flow.site.default.perpage")
            ),
        ];
    }
}
