<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Taxonomy extends Model
{
    protected $fillable = ["name", "slug", "type", "taxonomy_id"];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class, "taxonomy_id", "id");
    }
}
