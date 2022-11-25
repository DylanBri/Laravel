<?php

namespace Modules\Profile\Database\Seeders;;

use Database\Seeders\ProfilesTableSeeder;
use Illuminate\Database\Seeder;

class ProfileDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProfilesTableSeeder::class,

        ]);
    }
}
