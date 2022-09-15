
<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del post', 'autocomplete' => 'off']) !!}

    @error('name')
        <small class="text-danger">{{$message}}</small>    
    @enderror

</div>

<div class="form-group">
    {!! Form::label('slug', 'Slug') !!}
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

<div class="row mb-3">
    <div class="col">
        <div class="image-wraper">
            @isset ($post->image)
                <img id="picture" src="{{asset('storage/'.$post->image->url)}}" alt="">
            @else
                <img id="picture" src="{{asset('storage/defaultPost.jpg')}}" alt="">
            @endisset
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            {!! Form::label('file', 'Imagen que se mostrará en el post') !!}
            {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}

            @error('fila')
                <br>
                    <small class="text-danger">{{$message}}</small>    
            @enderror
        </div>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore suscipit illo vel obcaecati dolorem delectus quo molestias nihil animi nemo, veniam sed dicta non ad nulla tenetur quaerat sit iste?
        </p>
    </div>
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