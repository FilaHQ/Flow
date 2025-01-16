<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ["title", "type", "slug", "content", "published_at"];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        "published_at" => "date",
    ];

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull("published_at");
    }

    public function scopeDraft(Builder $query)
    {
        return $query->whereNull("published_at");
    }
}
