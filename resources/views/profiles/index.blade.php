@extends('layouts.app')
<!-- importante ferramenta para monitorar o desenvolvimento https://laravel.com/docs/5.8/telescope-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-4">
        <img src="{{$user->profile->profileImage()}}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-4">            
            <div class='d-flex justify-content-between align-items-baseline'>

            <div class="d-flex align-items-center">
                <div class="h4">{{$user->username}}</div>
            <!-- criado no arquivos resources/js/components/... e config resources/js/app.js, chama a view que esta no js FollowButton.vue -->
            <!-- cria variavel user-id="" para passar o id do usuario para o /js/components/FollowButton.vue-->
                <follow-button user-id="{{ $user->id }}" follows="{{$follows}}"></follow-button>
            </div>

            <!-- verifica se o perfil tem permissao para usar Adicionar novo post -->
                @can('update',$user->profile)
                <a href="/p/create">Adiciona Novo Post</a>
                @endcan
                
            </div>
            <!-- verifica se o perfil tem permissao para usar o Editar -->
            @can('update',$user->profile)
                <a href="/profile/{{$user->id}}/edit">Editar Perfil</a>
            @endcan

            <div class="d-flex pt-3">
                <div class='pr-3'>{{$postCount}} - Imagens </div>
                <!-- contando total de seguidores da funcao followers do profile.php -->
                <div class='pr-3'>{{$followersCount}} - Seguidores </div>
                <!-- contando total de seguidores da funcao following do user.php -->
                <div class='pr-3'>{{$followingCount}} - Seguindo </div>
            </div> 
            <div class='pr-3 font-weight-bold pt-3'>{{$user->profile->title}}</div> 
            <div class='pr-3'>{{$user->profile->description}}</div> 
            <div>Fonte : <a href="#">{{$user->profile->url}}</a></div>   
        </div>
    </div>

    <div class="row pt-4">
        @foreach($user->posts as $post)
             <div class="col-4 pb-3">
                <a href="/p/{{$post->id}}">
                    <img src="/storage/{{$post->image}}" class="w-100">
                </a>
             </div>  
        @endforeach
             
    </div>
</div>
@endsection
