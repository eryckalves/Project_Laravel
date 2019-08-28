<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowsController extends Controller
{

    //metodo para obrigar ter autenticacao
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //da a rota Route::post('follow/{user}','FollowsController@store');
    // *** CUIDADO \App\User tem que mostrar o caminho
    public function store(\App\User $user)
    {
        //return $user->username;
        // obriga a ter autorizacao para usar botao Follow e usa metodo laravel toggle
        return auth()->user()->following()->toggle($user->profile);
        
    }
}
