<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        // aggiungiamo il category_id nel fillable così nello store del Controller arrivano TUTTI i dati 
        'category_id'
    ];

    // creo una funzione pubblica per sapere a che categoria appartiene il post
    // belongsTo() significa "appartengo a..." e mette in relazione (one to many) il model Post (many) con Category (one)
    public function category(){

        return $this->belongsTo('App\Category');

    }

    public function tags(){
        // come nella one-to-many si utilizza il metodo belongsTo() per collegare il one al many
        // nel many-to-many si utilizza il metodo belongsToMany()
        return $this->belongsToMany('App\Tag');
    }

    // creo una funzione statica (::) per poterla richiamare DOPO nel seeder usando QUESTO Model (Post)
    public static function generateSlug($title){

        // genero lo slug
        $slug = Str::slug($title);
        $slug_base = $slug;
        
        // verifico se è presente nel mio DB
        // faccio la mia query (SELECT * FROM posts WHERE slug = $slug)
        // guarda se la colonna ('slug') contiene il mio slug ($slug) che ho appena generato 
        // alla fine si mette ->first() perchè vogliamo solo il primo risultato (come oggetto)
        // con ->get() invece restituisce una collection (che non ci serve)
        $post_presente = Post::where('slug', $slug)->first();
        
        // se è presente concateno allo slug un contatore
        $counter = 1;

        while($post_presente){
            $slug = $slug_base . '-' . $counter;
            $counter++;
            // a questo punto verifichiamo se è presente
            // se è presente il contatore sale e ricomincia il ciclo
            // se non è presente , la query fallisce e $post_presente diventa NULL interrompendo il ciclo
            $post_presente = Post::where('slug', $slug)->first();
        }

        return $slug;

    }
}
