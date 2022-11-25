<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSupAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'MERINDOL Cécilia SA',
            'email' => 'cecilia.merindol@planisphereinfo.com',
            'password' => Hash::make('Cplanis2018'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'quality' => 'Madame',
            'address' => '',
            'address2' => '',
            'zip_code' => '83600',
            'city' => 'Fréjus',
            'region' => 'PACA',
            'country' => 'France',
            'phone' => '',
            'mobile' => '',
            'enabled' => true,
            'suppressed' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
