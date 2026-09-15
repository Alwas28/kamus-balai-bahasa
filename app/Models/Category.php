<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_tolaki', 'slug', 'image_path', 'order'];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class)->orderBy('order');
    }
}
