<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Olga',
            'email' => 'moosbeere_O@mail.ru',
            'password' => Hash::make(123456),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Olga',
            'email' => 'ivanov@mail.ru',
            'password' => Hash::make(123456),
            'role_id' => 2,
        ]);
    }
}
