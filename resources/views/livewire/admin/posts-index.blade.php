<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12 d-flex">
                <div class="col-2">
                    <a class="btn btn-secondary" href="{{route('admin.posts.create')}}">Nuevo post</a>
                </div>
                <div class="col-10">
                    <input wire:model="search" class="form-control" placeholder="Ingrese el nombre de un post">
                </div>
            </div>
        </div>
    </div>
    
    @if ($posts->count())
    
        <div class="card-body">
            <table class="table table-striped" id="posts-index">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->name}}</td>
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.posts.edit', $post)}}">Editar</a>
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.posts.destroy', $post)}}" method="POST">
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

        <div class="card-footer">
            {{$posts->links()}}
        </div>

    @else
        <div class="card-body">
            <strong class="">No hay ningún registro...</strong>
        </div>
    @endif
    
</div>
