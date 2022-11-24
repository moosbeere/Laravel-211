<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use \App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ArticleSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
