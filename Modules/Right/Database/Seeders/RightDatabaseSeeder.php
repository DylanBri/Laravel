<?php

namespace Modules\Right\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RightDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RightActionsTableSeeder::class,
            RightFamiliesTableSeeder::class,
            RightsTableSeeder::class,
            // Default rights
            RightAndProfileTableSeeder::class

        ]);
    }
}
