<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() > 0) {
            return;
        }

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@larastart.com',
            'password' => bcrypt('secret')
        ]);

        $user->assignRole('administrator');;
    }
}
