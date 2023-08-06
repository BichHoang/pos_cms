<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'users.create.admin'],
            ['name' => 'users.create.owner'],
            ['name' => 'users.create.manager'],
            ['name' => 'users.create.staff'],
            ['name' => 'users.update.admin'],
            ['name' => 'users.update.owner'],
            ['name' => 'users.update.manager'],
            ['name' => 'users.update.staff'],
            ['name' => 'users.delete.admin'],
            ['name' => 'users.delete.owner'],
            ['name' => 'users.delete.manager'],
            ['name' => 'users.delete.staff'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $user_list = Permission::create(['name'=>'users.list']);
        $user_view = Permission::create(['name'=>'users.view']);
        $user_create = Permission::create(['name'=>'users.create']);
        $user_update = Permission::create(['name'=>'users.update']);
        $user_delete = Permission::create(['name'=>'users.delete']);

        $admin_permission = [
            $user_create,
            $user_list,
            $user_update,
            $user_view,
            $user_delete
        ];
        $user_permission = [
            $user_view,
            $user_update,
        ];

        $roles =[
            ['name' => 'SUPER ADMIN'],
            ['name' => 'ADMIN'],
            ['name' => 'OWNER'],
            ['name' => 'MANAGER'],
            ['name' => 'STAFF'],
            ['name' => 'USER'],
            ['name' => 'GUEST']
        ];
        foreach ($roles as $role) {
            $rs = Role::create($role);
            switch ($role) {
                case 'ADMIN':
                    $rs->givePermissionTo($admin_permission);
                    break;
                case 'USER':
                    $rs->givePermissionTo($user_permission);
                    break;
                default:
            }
        }

        $super_admin = User::create([
            'full_name' => 'SUPER ADMIN',
            'email' => 'super.admin@raica.com',
            'phone' => '0999999999',
            'password' => bcrypt('raica1212')
        ]);
        $super_admin->assignRole('SUPER ADMIN');

        $raica = User::create([
            'full_name' => 'Rai Ca',
            'email' => 'raica@raica.com',
            'phone' => '0999999999',
            'password' => bcrypt('raica1212')
        ]);

        $chipchip = User::create([
            'full_name' => 'Rai Ca',
            'email' => 'chipchip@raica.com',
            'phone' => '0888888888',
            'password' => bcrypt('raica1212')
        ]);

        $raica->assignRole('ADMIN');
        $chipchip->assignRole('ADMIN');

        $user = User::create([
            'full_name' => 'Nam Nam',
            'email' => 'user@user.com',
            'phone' => '0123456780',
            'password' => bcrypt('raica1212')
        ]);

        $user->assignRole('USER');
    }
}
