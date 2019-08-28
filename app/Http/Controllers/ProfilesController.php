<?php

namespace App\Http\Controllers;
//descomente para remover \App\User e apenas deixar User
//use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    //metodo mais facil de buscar as variaveis do user que esta sendo passado pelo Router -> {user}
    public function index(\App\User $user)
    {
        // verifica se o usuario esta seguindo ja se nao false
        $follows=(auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        //passa o total de posts , para Cache precisa biblioteca use Illuminate\Support\Facades\Cashe;
        $postCount = Cache::remember(
            // coloca um apelido unico
            'count.posts.' . $user->id, 
            // quantos tempo fica na cache
            now()->addSeconds(20), 
            // funcao de call back passando a classe user
            function() use($user)
            {
                return $user->posts->count();
            });

        //passa o total de seguidores , para Cache precisa biblioteca use Illuminate\Support\Facades\Cashe;
        $followersCount = Cache::remember(
            // coloca um apelido unico
            'count.followers.' . $user->id, 
            // quantos tempo fica na cache
            now()->addSeconds(20), 
            // funcao de call back passando a classe user
            function() use($user)
            {
                return  $user->profile->followers->count();
            });


        //passa o total de seguindo , para Cache precisa biblioteca use Illuminate\Support\Facades\Cashe;
        $followingCount = Cache::remember(
            // coloca um apelido unico
            'count.following.' . $user->id, 
            // quantos tempo fica na cache
            now()->addSeconds(20), 
            // funcao de call back passando a classe user
            function() use($user)
            {
                return $user->following->count();
            });

        //usando metodo acima da para utilizar compact() onde compact pode receber
        //mais de um atribubo ex compact('user','outracoisa')
        return view('profiles.index' , compact('user', 'follows','postCount','followersCount','followingCount'));
    }

    //metodo mais facil de buscar as variaveis do user que esta sendo passado pelo Router -> {user}
    //Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
    public function edit(\App\User $user)
    {
        //autorarizacao para poder utilizar o editar apenas o usario id = profile user_id
        //criado por php artisan make:policy ProfilePolicy -m Profile gerando arquivo ProfilePolicy.php 
        // para funcao update no ProfilePolicy
        $this->authorize('update',$user->profile);
        //usando metodo acima da para utilizar compact() onde compact pode receber
        //mais de um atribubo ex compact('user','outracoisa')
        return view('profiles.edit' , compact('user'));
    }

    //metodo mais facil de buscar as variaveis do user que esta sendo passado pelo Router -> {user}
    //Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
    public function update(\App\User $user)
    {

        //autorarizacao para poder utilizar o editar apenas o usario id = profile user_id
        //criado por php artisan make:policy ProfilePolicy -m Profile gerando arquivo ProfilePolicy.php 
        // para funcao update no ProfilePolicy
        $this->authorize('update',$user->profile);

        //valida os campos da pagina de editar e update caminho 
        //Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
        $data = request()->validate([
            //campo obrigatorio
            'title' => 'required',
            'description' =>'required',
            //validacao de campos do tipo link /url
            'url' => 'url',
            'image' =>'',
        ]);
                
        //verifica se tem nova imagem do perfil
        if(request('image')){
            // requer comando php artisan storage:link
            // envia para pasta e pega o caminho \profile\app\public\uploads
            $imagePath =request('image')->store('profile','public');

            // precisa do pacote *  comando composer require intervention/image
            // requer pacote use Intervention\Image\Facades\Image;
            // redimenciona a imagem , metodo fit nao eh igual ao resize
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000,1000);
            $image->save();

            $imageArray = ['image' => $imagePath ];
        }

        //autualiza se o profile tiver autorizacao user id = user_id profile
        //array_merge php para unir pela key e sobrescrever oque ja tem
        auth()->user()->profile->update(array_merge(
            $data,
            //se imagem nao existir ou nao for atualizada mande caminho vazio
            $imageArray ?? []
        ));

        //redireciona para o profile to usuario logado
        return redirect("/profile/{$user->id}");
    }

}
