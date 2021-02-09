<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $guarded = [];

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
