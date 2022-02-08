<?php

use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;

class PostsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*** QUESTO SEEDER è OPZIONALE ***/
        // posso crearlo anche mentre sto sviluppando anziche all'inizio del progetto

        // creiamo una 20na di record con le varie relazioni combinate
        for ($i=0; $i < 20; $i++) { 
            
            // estraggo random un post
            $post = Post::inRandomOrder()->first(); // dalla collection prendo solo il primo OGGETTO post (first)

            // estraggo random un id di un tag
            $tag_id = Tag::inRandomOrder()->first()->id; // prendo dalla collection il primo OGGETTO e prendo l'id

            // inserisco il dato nella tabella ponte (post_tag)
            // post ha una relazione ( tags() ) con i tags
            // a questa relazione fai un attach del tag_id estratto
            // ->attach() è l'equivalente del ->save() e inserisce un nuovo record nella tabella ponte
            $post->tags()->attach($tag_id);
            // tags() ha le parentesi perchè non chiediamo il dato, ma usiamo il metodo

        }

    }
}
