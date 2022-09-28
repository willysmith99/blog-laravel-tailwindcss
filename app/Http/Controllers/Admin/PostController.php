<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.posts.index')->only('index');
        $this->middleware('can:admin.posts.create')->only('create', 'store');
        $this->middleware('can:admin.posts.edit')->only('edit', 'update');
        $this->middleware('can:admin.posts.destroy')->only('destroy');

    }
 
    public function index()
    {
        return view('admin.posts.index'); 
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(PostRequest $request)
    {
        // return Storage::disk('public')->put('posts', $request->file('file'));

        $post = Post::create($request->all());

        // Se movera la imagen a la carpeta de posts
        if($request->file('file')){
            $url = Storage::disk('public')->put('posts', $request->file('file'));

            // Se guardará la url de la imagen en la tabla
            $post->image()->create([
                'url' => $url
            ]);
        }

        // Elimina la cache de la llave y realiza la consulta
        // para mostrar el nuevo post
        Cache::flush();

        // Para actualizar las etiquetas con collective
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('admin.posts.edit', compact('post'));
    }

    public function edit(Post $post)
    {
        // Validar que ese registro sea del usuario autenticado y permitira su actualización
        $this->authorize('author', $post);

        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));

    }

    public function update(PostRequest $request, Post $post)
    {
        // Validar que ese registro sea del usuario autenticado y permitira su actualización
        $this->authorize('author', $post);

        $post->update($request->all());

        if($request->file('file')){
            $url = Storage::disk('public')->put('posts', $request->file('file'));

            if($post->image){
                Storage::disk('public')->delete('posts', $post->image->url);

                $post->image()->update([
                    'url' => $url
                ]);

            }else {
                $post->image()->create([
                    'url' => $url
                ]);
            }
        }

        // Para actualizar las etiquetas con collective
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        Cache::flush();
        
        return redirect()->route('admin.posts.edit', $post)->with('alert', 'El post se actualizó con éxito');
    }

    public function destroy(Post $post)
    {
        // Validar que ese registro sea del usuario autenticado y permitira su eliminación
        $this->authorize('author', $post);

        $post->delete();

        Cache::flush();

        return redirect()->route('admin.posts.index')->with('alert', 'El post se eliminó con éxito');

    }
}
