<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Metodo Original do laravel
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

//*** CUIDADO router tem prioridade de sequencia , nao coloque /photo/{photo} ates de um /photo/create

// precisa ter configurado https://mailtrap.io 
//para visualizar o template do email se for criado (comando php artisan make:mail NewUserWelcomeMail -m emails.welcome-email)
Route::get('/email',function() 
{
    return new \App\Mail\NewUserWelcomeMail();
});

//nova rota para pagina inicial
Route::get('/','PostsController@index');

// rota para resource/js/FollowButton.vue
Route::post('follow/{user}', 'FollowsController@store');
//rota para a pagina de criar imagem (imagem + caption) metodo controller -> @create - /photo/create
Route::get('/p/create','PostsController@create');
//rota para gravar no banco a imagem com o texto caption metodo controller -> @store - /photo
Route::post('/p','PostsController@store');
//rota para pagina para mostrar o post da imagens com caption metodo controller -> @show /photo/{photo}
Route::get('/p/{post}','PostsController@show');


//rota para mostrar perfil usuario
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
//rota para editar perfil usuario
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
//rota para dar update no perfil do usuario patch ou put
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');


