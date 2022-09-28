@extends('adminlte::page')

@section('title', 'blog')

@section('content_header')
    <h1>Lista de roles</h1>
@stop

@section('content')

    @if (session('alert'))
        <div class="alert alert-success">
            {{session('alert')}}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.roles.create')}}" class="btn btn-secondary">Nuevo rol</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rol</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td width="100">
                                <a href="{{route('admin.roles.edit', $role)}}" class="btn btn-primary btn-sm">Editar</a>
                            </td>
                            <td width="100">
                                <form action="{{route('admin.roles.destroy', $role)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop