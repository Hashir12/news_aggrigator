<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'user_authors');
    }
}
