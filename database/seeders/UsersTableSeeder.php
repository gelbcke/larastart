<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $faker = Faker::create();
        $language = $faker->randomElement(['en', 'pt_BR']);

        foreach (range(1, 300) as $index) {
            DB::table('users')->insert([
                'id' => $faker->uuid(),
                'status' => $faker->numberBetween(0, 1),
                'name' => $faker->name($language),
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => $faker->password(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */

        if (User::count() > 0) {
            return;
        }

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@larastart.com',
            'password' => bcrypt('secret')
        ]);
    }
}
