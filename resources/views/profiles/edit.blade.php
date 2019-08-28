@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/profile/{{$user->id}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="row">
                <div class="col-8 offset-2">
                    <div class="row pl-3">
                        <h1>Editar Perfil</h1>
                    </div>
                    <div class="form-group row pl-2">
                        <label for="title" class="col-4 col-form-label">Titulo</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input id="title"
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                name="title"
                                value="{{ old('title') ?? $user->profile->title }}" 
                                required autocomplete="title" 
                                autofocus>
                        </div>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $title }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row pl-2">
                        <label for="description" class="col-4 col-form-label">Descrição</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input id="description"
                                type="text" 
                                class="form-control @error('description') is-invalid @enderror" 
                                name="description"
                                value="{{ old('description') ?? $user->profile->description}}" 
                                required autocomplete="description" 
                                autofocus>
                        </div>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $description }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row pl-2">
                        <label for="url" class="col-4 col-form-label">Link - URL</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input id="url"
                                type="text" 
                                class="form-control @error('url') is-invalid @enderror" 
                                name="url"
                                value="{{ old('url') ?? $user->profile->url  }}" 
                                required autocomplete="url" 
                                autofocus>
                        </div>
                        @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $url }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="row pl-2 pt-2">
                        <label for="image" class="col-4 col-form-label">Imagem Perfil</label>
                        <input type="file" class="form-control-file pt-1 pl-2" id="image" name="image">
                        
                        @if($errors->has('image'))
                            <strong>{{ $errors->first('image') }}</strong>
                        @endif

                    </div>
                    <div class="row pt-5 pl-3">
                    <button class="btn btn-primary">Salvar</button>
                    </div>
                </div>   
            </div>

    </form>
</div>
@endsection
