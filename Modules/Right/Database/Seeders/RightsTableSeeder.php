<?php

namespace Modules\Right\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rights')->insert([
            'family_id' => 2,
            'action_id' => 1,
            'client_id' => 1,
            'name' => 'Consulter Administrateur',
            'code' => 'SEEADM',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 2,
            'action_id' => 2,
            'client_id' => 1,
            'name' => 'Ajouter Administrateur',
            'code' => 'ADDADM',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 2,
            'action_id' => 3,
            'client_id' => 1,
            'name' => 'Modifier Administrateur',
            'code' => 'UPDADM',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 3,
            'action_id' => 1,
            'client_id' => 1,
            'name' => 'Consulter Manager',
            'code' => 'SEEMNG',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 3,
            'action_id' => 2,
            'client_id' => 1,
            'name' => 'Ajouter Manager',
            'code' => 'ADDMNG',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 3,
            'action_id' => 3,
            'client_id' => 1,
            'name' => 'Modifier Manager',
            'code' => 'UPDMNG',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 4,
            'action_id' => 1,
            'client_id' => 1,
            'name' => 'Consulter Membre',
            'code' => 'SEEUSR',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 4,
            'action_id' => 2,
            'client_id' => 1,
            'name' => 'Ajouter Membre',
            'code' => 'ADDUSR',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 4,
            'action_id' => 3,
            'client_id' => 1,
            'name' => 'Modifier Membre',
            'code' => 'UPDUSR',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 5,
            'action_id' => 1,
            'client_id' => 1,
            'name' => 'Consulter Visiteur',
            'code' => 'SEEPBL',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 5,
            'action_id' => 2,
            'client_id' => 1,
            'name' => 'Ajouter Visiteur',
            'code' => 'ADDPBL',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rights')->insert([
            'family_id' => 5,
            'action_id' => 3,
            'client_id' => 1,
            'name' => 'Modifier Visiteur',
            'code' => 'UPDPBL',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
