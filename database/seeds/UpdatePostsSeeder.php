<?php

use App\Category;
use App\Post;
use Illuminate\Database\Seeder;

class UpdatePostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // estraggo tutti i post
        $posts = Post::all();

        // per ogni post singolo estraggo random gli id dalla tabella "Category" in relazione 
        foreach($posts as $post){
            
            $data = [
                'category_id' => Category::inRandomOrder()->first()->id
            ];
            
            // eseguo un dump per vedere se gli id sono stati presi correttamente
            // dump($data);

            // eseguo l'update di ogni singolo post con i nuovi dati 
            // $data (in questo caso) è il primo "id" estratto randomicamente dalla tabella Category
            // e $data (vedi sopra nel foreach) è un array associativo perchè è il metodo update() che lo richiede
            $post->update($data);

            //  volendo funziona anche così
            // $post->category_id = Category::inRandomOrder()->first()->id;
            // $post->update();

        };
    
    }
}
