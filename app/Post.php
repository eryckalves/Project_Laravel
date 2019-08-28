<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //ignora permissao do laravel pq ja esta sendo tratado no PostsController.php
    protected $guarded = [];

    //relacionamento user e post , onde este post pertence ao usuario (user 1 <-> n post)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
