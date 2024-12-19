<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserService
{

    public function userRegister($request): array
    {

        if (!is_null($request)) {

            $imagePath = ' ';
            if ($request->hasFile('image')) {

                $ext = $request->file('image')->extension();

                $final_name = date('YmdHis') . '.' . $ext;

                $request->file('image')->move(public_path('uploads/users'), $final_name);

                $imagePath = '/uploads/users/' . $final_name;
            }

            $user = User::query()->create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone' => $request['phone'],
                'password' => bcrypt($request['password']),
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'image' => $imagePath,
            ]);

            $clientRole = Role::query()->firstWhere('name', 'client');
            $user = $user->assignRole($clientRole);

            $permissions = $clientRole->permissions()->pluck('name')->toArray();
            $user->givePermissionTo($permissions);

            $user->load('roles', 'permissions');

            $user = User::query()->find($user['id']);
            $user = $this->appendRolesAndPermissions($user);
            $user['token'] = $user->createToken("Access Token")->plainTextToken;

            $message = 'user created successfully';
            $code = 201;
        }
        else {
            $user = [];
            $message = 'invalid request';
            $code = 400;
        }
        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    private function appendRolesAndPermissions($user){
        $roles = [];

        foreach ($user->roles as $role){
            $roles[] = $role->name;
        }

        unset($user['roles']);
        $user['roles'] = $roles;

        $permissions = [];
        foreach ($user->permissions as $permission){
            $permissions[] = $permission->name;
        }
        unset($user['permissions']);
        $user['permissions'] = $permissions;

        return $user;
    }
}
