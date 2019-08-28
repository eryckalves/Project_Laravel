<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //desabilitando segurança de campos do laravel ja esta sendo tratado no ProfilesController 
    protected $guarded = [];

    // imagem padrao do profile se nao existir uma
    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'profile/imagemperfil.jpeg';
        return '/storage/' . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    //relacionamento user e profile , onde este profile pertence ao usuario (user 1 <-> 1 profile)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
