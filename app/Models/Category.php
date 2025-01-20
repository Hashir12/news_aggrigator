<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_categories');
    }
}
