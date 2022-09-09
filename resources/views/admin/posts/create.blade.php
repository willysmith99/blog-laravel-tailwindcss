@extends('adminlte::page')

@section('title', 'blog')

@section('content_header')
    <h1>Crear nuevo post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.posts.store']) !!}

            {!! Form::hidden('user_id', auth()->user()->id) !!}

                <div class="form-group">
                    {!! Form::label('name', 'nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del post', 'autocomplete' => 'off']) !!}

                    @error('name')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    {!! Form::label('slug', 'slug') !!}
                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el slug del post', 'readonly']) !!}

                    @error('slug')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Categoría') !!}
                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}

                    @error('category_id')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    <p class="font-weight-bold"><span class="text-danger">*</span> Etiqueta</p>

                    @foreach ($tags as $tag)
                        <label class="mr-3">
                            {!! Form::checkbox('tags[]', $tag->id, null) !!}
                            {{ $tag->name }}
                        </label>
                    @endforeach

                    @error('tags')
                    <br>
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    <p class="font-weight-bold"><span class="text-danger">*</span> Estado</p>

                    <label class="mr-3">
                        {!! Form::radio('status', 1, true) !!}
                        Borrador
                    </label>

                    <label>
                        {!! Form::radio('status', 2) !!}
                        Publicado
                    </label>

                    @error('status')
                    <br>
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    {!! Form::label('extract', 'Extracto') !!}
                    {!! Form::textarea('extract', null, ['class' => 'form-control']) !!}

                    @error('extract')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Cuerpo del post') !!}
                    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}

                    @error('body')
                        <small class="text-danger">{{$message}}</small>    
                    @enderror

                </div>

                {!! Form::submit('Crear post', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready( function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });

        ClassicEditor
        .create( document.querySelector( '#extract' ) )
        .catch( error => {
            console.error( error );
        } );

        ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    </script>
@endsection