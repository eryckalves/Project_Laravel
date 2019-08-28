@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
        <div class="row">
            <div class="col-5 offset-2">
                <a href="/profile/{{$post->user->id}}">
                    <img src="/storage/{{$post->image}}" class="w-100">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4 offset-2">
            <div class="col-5">
                <div>
                    <p>{{$post->caption}}</p>
                </div>        
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
        <!-- toda vez q usar paginate() (criado no PostsController.php) para passar para 
        proxima pagina usar funcao links() -->
            {{$posts->links()}}
        </div>
    </div>
</div>
@endsection
