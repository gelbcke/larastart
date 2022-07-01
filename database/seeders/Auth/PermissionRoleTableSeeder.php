<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $super_admin = Role::create(['name' => 'super admin']);
        $administrator = Role::create(['name' => 'administrator']);

        // Create Permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        // Assign Permissions to Roles
        $administrator->givePermissionTo(Permission::all());
    }
}
