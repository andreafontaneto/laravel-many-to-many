<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            
            // prima creo la colonna della ForeignKey (FK)
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            // poi assegno la FK alal colonna creata
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    // con onDelete ('set null') se elimino una categoria presente in alcuni post, scriverà NULL 
                    ->onDelete('set null');
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            
            // nel down l'eliminazione deve essere speculare all'up quindi...

            // ... prima eliminare la FK
            // dropForeign accetta un array
            $table->dropForeign(['category_id']);

            // ...poi elimino la colonna intera
            $table->dropColumn('category_id');


        });
    }
}
