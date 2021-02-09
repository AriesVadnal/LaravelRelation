<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function posts() {
        return $this->hasManyThrough(Post::class, User::class, 'role_id','user_id','id','id');
    }
}
