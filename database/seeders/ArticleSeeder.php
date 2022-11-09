<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article = new Article();
        $result = json_decode(file_get_contents(public_path().'/articles.json'), true);
        $article->fill($result);
        $article->save();
    }
}
