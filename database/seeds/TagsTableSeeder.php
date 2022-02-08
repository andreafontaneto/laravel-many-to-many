<?php

use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['Front End', 'Back End', 'Design', 'UX', 'Laravel', 'VueJs'];

        foreach($tags as $tag){

            $new_tag = new Tag();
            $new_tag->name = $tag;
            $new_tag->slug = Str::slug($new_tag->name, '-');
            $new_tag->save();

        }

    }
}
