<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'SA',
        ]);
        DB::table('roles')->insert([
            'name' => 'ADM',
        ]);
        DB::table('roles')->insert([
            'name' => 'MNG',
        ]);
        DB::table('roles')->insert([
            'name' => 'USR',
        ]);
        DB::table('roles')->insert([
            'name' => 'PBL',
        ]);
    }
}
