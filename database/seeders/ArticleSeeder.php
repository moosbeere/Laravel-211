<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use File;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/articles.json");
        $articles = json_decode($json);
  
        foreach ($articles as $key => $value) {
            Article::create([
                "date" => $value->date,
                "name" => $value->name,
                "preview_image" => $value->preview_image,
                "full_image" => $value->full_image,
                "shortDesc" => $value->shortDesc,
                "desc" => $value->desc,
            ]);
        }
    }
}
