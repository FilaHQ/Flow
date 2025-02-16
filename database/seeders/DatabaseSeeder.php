<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\Term;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $category = Taxonomy::create([
            "name" => "Category",
            "slug" => "category",
            "type" => "dropdown",
        ]);
        $tags = Taxonomy::create([
            "name" => "Tags",
            "slug" => "tags",
            "type" => "tags",
            "options" => [
                "route" => true,
            ],
        ]);
        $series = Taxonomy::create([
            "name" => "Series",
            "slug" => "series",
            "type" => "checkbox",
            "options" => [
                "required" => "true",
                "route" => true,
            ],
        ]);
        $category
            ->terms()
            ->saveMany([
                new Term(["name" => "Category A", "slug" => "category-a"]),
                new Term(["name" => "Category B", "slug" => "category-b"]),
                new Term(["name" => "Category C", "slug" => "category-c"]),
            ]);
        $tags
            ->terms()
            ->saveMany([
                new Term(["name" => "Tag 1", "slug" => "tag-1"]),
                new Term(["name" => "Tag 2", "slug" => "tag-2"]),
                new Term(["name" => "Tag 3", "slug" => "tag-3"]),
            ]);
        $series
            ->terms()
            ->saveMany([
                new Term(["name" => "Series One", "slug" => "series-one"]),
                new Term(["name" => "Series Two", "slug" => "series-two"]),
                new Term(["name" => "Series Three", "slug" => "series-three"]),
            ]);

        Post::factory()
            ->count(20)
            ->create()
            ->each(function (Post $post) {
                $randoms = Term::get()->random(3)->pluck("id");
                $post->taxos()->sync($randoms);
            });
    }
}
