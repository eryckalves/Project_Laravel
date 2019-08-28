@extends('layouts.app')

@section('content')
<div class="container">

    <form action="/p" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
                <div class="col-8 offset-2">
                    <div class="row pl-3">
                        <h1>Adicionar Nova Imagem</h1>
                    </div>
                    <div class="form-group row pl-2">
                        <label for="Caption" class="col-4 col-form-label">Incluir Comentários</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input id="caption"
                                type="text" 
                                class="form-control @error('Caption') is-invalid @enderror" 
                                name="caption"
                                value="{{ old('Caption') }}" 
                                required autocomplete="Caption" 
                                autofocus>
                        </div>
                        @error('Caption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $caption }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row pl-2 pt-2">
                        <label for="image" class="col-4 col-form-label">Incluir imagem</label>
                        <input type="file" class="form-control-file pt-1 pl-2" id="image" name="image">
                        
                        @if($errors->has('image'))
                            <strong>{{ $errors->first('image') }}</strong>
                        @endif

                    </div>
                    <div class="row pt-5 pl-3">
                    <button class="btn btn-primary">Adicionar</button>
                    </div>
                </div>   
            </div>

    </form>

</div>
@endsection
