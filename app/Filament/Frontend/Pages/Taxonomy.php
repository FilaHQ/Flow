<?php

namespace App\Filament\Frontend\Pages;

use Filament\Pages\Page;
use App\Models\Post;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Infolist;
use App\Models\Taxonomy as TaxonomyModel;
use App\Models\Term;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class Taxonomy extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected static ?string $navigationIcon = "heroicon-o-document-text";

    protected static string $view = "filament.frontend.pages.listing";

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = "{taxonomy}/{term}";

    public $term;
    public $taxonomy;

    public function mount(Post $post, $taxonomy, $term): void
    {
        $this->term = Term::where("slug", $this->term)->firstOrFail();
        $this->taxonomy = TaxonomyModel::where(
            "slug",
            $this->taxonomy
        )->firstOrFail();
    }

    public function getTitle(): string
    {
        return $this->term->name ?? "";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->taxonomy->name ?? "";
    }

    protected function getViewData(): array
    {
        return [
            "posts" => $this->term
                ->posts()
                ->published()
                ->orderBy("published_at", "desc")
                ->simplePaginate(config("flow.site.default.perpage")),
        ];
    }

    public function content(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Livewire::make("listing", [
                "type" => "taxonomy",
                "term" => $this->term,
            ]),
        ]);
    }
}
