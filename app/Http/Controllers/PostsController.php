<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;
class PostsController extends Controller
{
    //funcao para obrigar ter autenticacao
    public function __construct()
    {
        $this->middleware('auth');
    }

    //funcao para tratar a pagina inicial do web.php
    public function index()
    {
        //traz todos os ids que o usuario logado esta seguindo
        $users = auth()->user()->following()->pluck('profiles.user_id');
        //traga todos user_id que vieram do $users
        // pode usar orderBy('created_at','DESC') para ordenar ou latest() ou first()
        // funcao paginate() serve para paginar , tem q passar valor que deseja aparecer antes de paginar
        // funcao with traz o relacionamento da tabela user e post
        $posts = \App\Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);

        //funcao compact facilita em vez de : return view('posts.index' , ['posts' => $posts]);
        return view('posts.index',compact('posts'));
    }

    //funcao para retornar a view do posts
    public function create()
    {
        return view('posts.create');
    }

    //funcao para armazenar no banco de dados com validação de dados
    public function store()
    {
        //metodo para validar se os campos estao preenchidos.
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required','image'],
        ]);

        // requer comando php artisan storage:link
        // envia para pasta e pega o caminho \storage\app\public\uploads
        $imagePath =request('image')->store('uploads','public');

        // precisa do pacote *  comando composer require intervention/image
        // requer pacote use Intervention\Image\Facades\Image;
        // redimenciona a imagem , metodo fit nao eh igual ao resize
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
        $image->save();
        /*maneira mais facil de gravar no banco ja buscando a autenticacao , 
        trazendo o id lagado para preencher o relacionamento da tabela no banco. 
        */

        auth()->user()->posts()->create([
            //se não tivesse o caminha alternativo da imagem basta usar o $data
            'caption' => $data['caption'],
            'image' =>$imagePath,
        ]);
        //redireciona para o profile
        return redirect('/profile/'.auth()->user()->id);
    }

    // funcao show do arquivo web do Router
    public function show(\App\Post $post)
    {
        //funcao compact facilita em vez de : return view('posts.show' , ['post' => $post]);
        return view('posts.show' , compact('post'));
    }
}
