<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        // Para actualizar las etiquetas con collective
        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('admin.posts.edit', compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // Validar que ese registro sea del usuario autenticado y permitira su actualización
        $this->authorize('author', $post);

        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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


        return redirect()->route('admin.posts.edit', $post)->with('alert', 'El post se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Validar que ese registro sea del usuario autenticado y permitira su eliminación
        $this->authorize('author', $post);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('alert', 'El post se eliminó con éxito');

    }
}
