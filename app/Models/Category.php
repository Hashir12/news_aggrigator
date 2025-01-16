<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
