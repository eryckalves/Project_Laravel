<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        //create_at variavel do timestamps() declarado no migration do database , assim como uptade_at
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    //se for primeira vez com um usuario sem profile vai executar essa rodina da funcao para pagina de cadastro
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user){
            $user->profile()->create([
                'title' =>$user->username,
            ]);

            //apos preencher as informacoes de cadastro
            // precisa de mailtrap https://mailtrap.io e precisa configurar arquivo
            // .env com as informacoes do email_drive , login e senha fornecido no mailtrap.io
            // precisa do comando php artisan make:mail NewUserWelcomeMail -m emails.welcome-email (gera no pasta app/mail)
            // e a view do email
            // NewUserWelcomeMail() vem do arquivo NewUserWelcomeMail.php
            Mail::to($user->email)->send(New \App\Mail\NewUserWelcomeMail());

        });
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
