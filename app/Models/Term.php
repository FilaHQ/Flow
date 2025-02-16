<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Term extends Model
{
    protected $fillable = ["name", "slug"];

    protected $appends = ["taxonomy_type", "url"];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, "model", "model_terms");
    }

    public function taxo(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, "taxonomy_id", "id");
    }

    public function getUrlAttribute()
    {
        return url($this->taxo->slug . "/" . $this->slug);
    }

    public function getTaxonomyTypeAttribute(): string
    {
        return $this->taxo->slug;
    }
}
