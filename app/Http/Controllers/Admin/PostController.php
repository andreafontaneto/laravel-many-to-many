<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // recupero tutti i post
        // li riordino per id in ordine decrescente
        // li impagino di 5 per pagina
        $posts =  Post::orderBy('id', 'desc')->paginate(5);

        // recupero tutte le categorie esistenti
        $categories = Category::all();

        // faccio un return della vista corretta e passo come parametri i post E le categorie
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        // recupero i tags esistenti
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'=>'required|max:255|min:2',
                'content'=>'required'
            ],
            [
                'title.required'=>'Il titolo è un campo richiesto',
                'title.max'=>'Il titolo non deve superare :max caratteri',
                'title.min'=>'Il titolo non deve avere meno di :min caratteri',

                'content.required'=>'Il contenuto è un campo richiesto'
            ]
        );

        $data = $request->all();

        $new_post = new Post();
        // $new_post->title = $data['title'];
        // $new_post->content = $data['content'];
        $new_post->fill($data);
        $new_post->slug = Post::generateSlug($new_post->title); // oppure anche data['title'];
        // dd($new_post); per vedere se arriva tutto correttamente
        $new_post->save();

        // verifico l'esistenza dell'chiave tags (che è un array) DENTRO all'array $data
        if (array_key_exists('tags', $data)) {
            // SE esite eseguo l'attach ( DA FARE DOPO il ->save() )
            // attach() crea una relazione tra 2 record
            $new_post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if ($post) {
            return view('admin.posts.show', compact('post'));
        }

        abort(404, 'Il post non è presente nel database');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $categories = Category::all();

        $tags = Tag::all();

        if ($post) {
            return view('admin.posts.edit', compact('post', 'categories', 'tags'));
        }

        abort(404, 'Il post è stato modificato, cancellato o la pagina non esiste più');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title'=>'required|max:255|min:2',
                'content'=>'required'
            ],
            [
                'title.required'=>'Il titolo è un campo richiesto',
                'title.max'=>'Il titolo non deve superare :max caratteri',
                'title.min'=>'Il titolo non deve avere meno di :min caratteri',

                'content.required'=>'Il contenuto è un campo richiesto'
            ]
        );

        $post_data = $request->all();
        if ($post_data['title'] != $post->title) {
            $post_data['slug'] = Post::generateSlug($post_data['title']);
        }

        $post->update($post_data);

        // verifico l'esistenza dell'chiave tags (che è un array) DENTRO all'array $post_data
        // SE esite aggiorno le relazioni
        // se non esiste cancello tutte le relazioni
        if (array_key_exists('tags', $post_data)) {
            // SE esite eseguo il sync ( DA FARE DOPO ->update() )
            // sync() sostituisce (quindi elimina e riscrive) tutte le relazioni con quelle che vengono passate come parametro
            $post->tags()->sync($post_data['tags']);
        }else {
            // se non viene inviato nessun tag devo cancellare tutte le relazioni
            $post->tags()->sync([]);
            // detach() elimina le relazioni tra 2 record
            // passandogli un parametro elimina SOLO quella relazione
            // non passandogli NIENTE elimina tutto
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        /***
        NON DOBBIAMO AGGIUGNERE NIENTE perchè...
        ...grazie al ->onDelete('cascade') quando eliminiamo un post o un tag in automatico viene eliminata anche la relazione cancellando il record dalla tabella ponte "post_tag"

        SE INVECE ci fosse stato ->onDelete(setNull) dovevamo fare il detach() PRIMA del delete()
        
        ***/

        $post->delete();

        return redirect()->route('admin.posts.index')->with('deleted', 'Il post è stato eliminato correttamente');
    }
}
