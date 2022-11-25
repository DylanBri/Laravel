<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'PlanisphereInfo',
            'folder' => '',
            'address' => '51 Impasse Thomas Edison',
            'address2' => '',
            'zip_code' => '83600',
            'city' => 'Fréjus',
            'country' => 'France',
            'email' => 'cecilia.merindol@planisphereinfo.com',
            'phone' => '',
            'socket_host' => '',
            'socket_port' => '',
            'enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
