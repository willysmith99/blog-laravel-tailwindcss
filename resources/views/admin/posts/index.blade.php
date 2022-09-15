@extends('adminlte::page')

@section('title', 'blog')

@section('content_header')
    <h1>Listado de post</h1>
@stop

@section('content')

    @if (session('alert'))
        <div class="alert alert-success" role="alert">
            <strong>{{session('alert')}}</strong>
        </div>
    @endif
    
    @livewire('admin.posts-index')
@stop

