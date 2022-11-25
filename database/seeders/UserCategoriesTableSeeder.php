<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_categories')->insert([
            'name' => 'Super Administrateur',
            'role_id' => 1,
        ]);
        DB::table('user_categories')->insert([
            'name' => 'Administrateur',
            'role_id' => 2,
        ]);
        DB::table('user_categories')->insert([
            'name' => 'Manageur',
            'role_id' => 3,
        ]);
        DB::table('user_categories')->insert([
            'name' => 'Membre',
            'role_id' => 4,
        ]);
        DB::table('user_categories')->insert([
            'name' => 'Visiteur',
            'role_id' => 5,
        ]);
    }
}
