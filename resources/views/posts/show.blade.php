@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
        <img src="/storage/{{$post->image}}" class="w-100">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">

                    <div class="pr-2">
                    <!-- nao temos $user aqui temos q usar os relacionamento de tabelas para chegar profile->image -->
                        <img src="{{$post->user->profile->profileImage()}}" class="rounded-circle w-100" style="max-width : 40px">
                    </div>
                    <div class="d-flex">
                        <div>
                        <!-- nao temos $user aqui temos q usar os relacionamento de tabelas para chegar user->id -->
                            <h5 class="font-weight-bol">
                                <a class="text-dark" href="/profile/{{$post->user->id}}">{{$post->user->username}}</a>
                            <h5>
                        </div>

                        <div class="pl-2">
                            <a class="" href="#">Facebook</a>
                        </div>
                    </div>
                </div>
                <hr/>
                <p>{{$post->caption}}</p>
            </div>        
        </div>
    </div>
</div>
@endsection
