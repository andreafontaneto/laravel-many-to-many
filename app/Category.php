<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // facendo una query del tipo $category = Category::find($id)
    // voglio sapere quali sono i post con quella categoria in un array così: $category->post()
    // la proprietà ->post() è in realtà un metodo
    // hasMany() significa "ha molti..." e mette in relazione (one to many) il model Category (one) con Post (many)
    public function posts(){
        
        return $this->hasMany('App\Post');
    
    }
}
