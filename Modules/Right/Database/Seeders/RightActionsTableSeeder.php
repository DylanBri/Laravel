<?php

namespace Modules\Right\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RightActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('right_actions')->insert([
            'client_id' => 1,
            'name' => 'Consulter',
            'code' => 'SEE',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_actions')->insert([
            'client_id' => 1,
            'name' => 'Ajouter',
            'code' => 'ADD',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_actions')->insert([
            'client_id' => 1,
            'name' => 'Modifier',
            'code' => 'UPD',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('right_actions')->insert([
            'client_id' => 1,
            'name' => 'Supprimer',
            'code' => 'DEL',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
