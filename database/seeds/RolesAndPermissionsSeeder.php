r<?php
/**
 * User: pgorski42
 * Date: 26.10.17
 * Time: 00:53
 */

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $levels = [
            [
                'delete users',
            ],
            [
                'create_users',
                'edit users',
                'delete websites',
            ],
            [
                'create websites',
                'edit websites',
                'publish websites',
                'unpublish websites',
            ]
        ];

        foreach ($levels as $permissions)
            foreach ($permissions as $permission)
                Permission::create(['name' => $permission]);

        $role = Role::create(['name' => 'admin']);
        for ($i = 0; $i < 3; $i++) {
            foreach ($levels[$i] as $permission)
                $role->givePermissionTo($permission);
        }

        $role = Role::create(['name' => 'moderator']);
        for ($i = 1; $i < 3; $i++) {
            foreach ($levels[$i] as $permission)
                $role->givePermissionTo($permission);
        }

        $role = Role::create(['name' => 'publisher']);
        for ($i = 2; $i < 3; $i++) {
            foreach ($levels[$i] as $permission)
                $role->givePermissionTo($permission);
        }
    }
}
