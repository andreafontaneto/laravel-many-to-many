<?php

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++){
            $new_post = new Post();
            $new_post->title = $faker->sentence();
            $new_post->content = $faker->text();
            // richiamo la MIA funzione statica (::) fatta nel Model
            // la funzione statica è una funzione che posso richiamare SENZA aver istanziato l'oggetto
            $new_post->slug = Post::generateSlug($new_post->title);
            // per vedere se funziona faccio un dump
            // 
            $new_post->save();
        }
    }
}
