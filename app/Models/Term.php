<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Term extends Model
{
    protected $fillable = ["name", "slug"];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, "model_terms");
    }

    public function taxo(): BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, "taxonomy_id", "id");
    }
}
