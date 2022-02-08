<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*** questa è la TABELLA PONTE tra POSTS e TAGS ***/
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
                // all'eliminazione di un post o di un tag viene eliminato in cascata (cascade) il record
                // "cascade" serve per eliminare tutta la relazione tra i due id
                // non ha senso tenerne uno solo come con setNull

            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
                

            // $table->timestamps(); non serve
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
