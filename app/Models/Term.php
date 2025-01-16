<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ["name", "slug"];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, "model_terms");
    }
}
