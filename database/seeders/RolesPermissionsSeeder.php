<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $clientRole = Role::create(['name' => 'client']);

        $permissions = [
            'all.all'
        ];

        foreach($permissions as $permissionName) {
            Permission::findOrCreate($permissionName, 'web');
        }

        $moderatorRole->givePermissionTo('all.all');

        $clientRole->givePermissionTo('all.all');

        $adminRole->syncPermissions($permissions);

        $admin = User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '0949623988',
            'password' => Hash::make('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'role' => 'admin',
        ]);

        $admin->assignRole($adminRole);
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $admin->givePermissionTo($permissions);


        $moderator = User::factory()->create([
            'first_name' => 'moderator',
            'last_name' => 'moderator',
            'phone' => '0930610494',
            'password' => Hash::make('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'role' => 'moderator',
        ]);

        $moderator->assignRole($moderatorRole);
        $permissions = $moderatorRole->permissions()->pluck('name')->toArray();
        $moderator->givePermissionTo($permissions);


        $client = User::factory()->create([
            'first_name' => 'user',
            'last_name' => 'user',
            'phone' => '0967667180',
            'password' => Hash::make('password'),
            'gender' => 'M',
            'birth_date' => Carbon::now(),
            'role' => 'client',
        ]);

        $client->assignRole($clientRole);
        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $client->givePermissionTo($permissions);
    }
}
