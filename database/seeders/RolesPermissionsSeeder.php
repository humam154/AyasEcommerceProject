<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::create(['name' => 'moderator']);
        $userRole = Role::create(['name' => 'user']);

        $permissions = [
            'all.all'
        ];

        foreach($permissions as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $moderatorRole->givePermissionTo('all.all');

        $userRole->givePermissionTo('all.all');

        $adminRole->syncPermissions($permissions);

        $admin = User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '0949623988',
            'password' => bcrypt('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'available_ads' => false
        ]);

        $admin->assignRole($adminRole);
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $admin->givePermissionTo($permissions);


        $moderator = User::factory()->create([
            'first_name' => 'moderator',
            'last_name' => 'moderator',
            'phone' => '0930610494',
            'password' => bcrypt('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'available_ads' => false
        ]);

        $moderator->assignRole($moderatorRole);
        $permissions = $moderatorRole->permissions()->pluck('name')->toArray();
        $moderator->givePermissionTo($permissions);


        $user = User::factory()->create([
            'first_name' => 'user',
            'last_name' => 'user',
            'phone' => '0967667180',
            'password' => bcrypt('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'available_ads' => false
        ]);

        $user->assignRole($userRole);
        $permissions = $userRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);
    }
}