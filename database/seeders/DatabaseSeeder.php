<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Database\Seeders\Auth\UsersTableSeeder;
use Database\Seeders\System\CurrenciesTableSeeder;
use Database\Seeders\System\TimezoneTableSeeder;
use Database\Seeders\System\SystemSettingsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            CurrenciesTableSeeder::class,
            TimezoneTableSeeder::class,
            SystemSettingsSeeder::class
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
