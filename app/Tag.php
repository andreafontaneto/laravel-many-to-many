<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts(){
        // come nella one-to-many si utilizza il metodo belongsTo() per collegare il one al many
        // nel many-to-many si utilizza il metodo belongsToMany()
        return $this->belongsToMany('App\Post');
    }
}
