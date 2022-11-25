<?php

namespace Modules\Right\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RightFamiliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('right_families')->insert([
            'client_id' => 1,
            'name' => 'Tous',
            'code' => 'SAD',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_families')->insert([
            'client_id' => 1,
            'name' => 'Administrateur',
            'code' => 'ADM',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_families')->insert([
            'client_id' => 1,
            'name' => 'Manager',
            'code' => 'MNG',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_families')->insert([
            'client_id' => 1,
            'name' => 'Membre',
            'code' => 'USR',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_families')->insert([
            'client_id' => 1,
            'name' => 'Visiteur',
            'code' => 'PBL',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
