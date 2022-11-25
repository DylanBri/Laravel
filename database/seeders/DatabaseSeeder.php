<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Profile\Database\Seeders\ProfileDatabaseSeeder;
use Modules\Right\Database\Seeders\RightDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ClientsTableSeeder::class,
            RolesTableSeeder::class,
            UserCategoriesTableSeeder::class,
            UsersSupAdminTableSeeder::class,
            // Modules
            ProfileDatabaseSeeder::class,
            RightDatabaseSeeder::class
        ]);
    }
}
