<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
class Page extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "posts";

    protected $fillable = ["title", "type", "slug", "content", "published_at"];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        "published_at" => "date",
    ];

    protected $appends = ["link"];

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull("published_at");
    }

    public function scopeType(Builder $query, string $type)
    {
        return $query->where("type", $type);
    }
    public function scopeDraft(Builder $query)
    {
        return $query->whereNull("published_at");
    }

    public function getLinkAttribute()
    {
        return url($this->slug);
    }
}
