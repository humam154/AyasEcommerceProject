<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminService
{
    public function login($request): array
    {
        $user = User::query()->where('phone', $request['phone'])->first();
        if(!is_null($user)) {
            if ($user['role'] == 'admin') {
                if (!Auth::attempt($request->only(['phone', 'password']))) {
                    $user = [];
                    $message = 'phone or password is wrong';
                    $code = 401;
                } else {
                    $user = $this->appendRolesAndPermissions($user);
                    $user['token'] = $user->createToken("Access Token")->plainTextToken;
                    $message = 'user logged in successfully';
                    $code = 200;
                }
            } else {
                $user = [];
                $message = 'not and admin';
                $code = 403;
            }
        } else {
            $message = 'user not found';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }
    public function logout(): array
    {
        $user = Auth::user();

        if(!is_null($user)) {
            if ($user['role'] == 'admin') {
                $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
                $message = 'user logged out successfully';
                $code = 200;
            } else {
                $user = [];
                $message = 'not an admin';
                $code = 403;
            }
        } else {
            $message = 'invalid token';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }
    public function changePassword($request): array
    {
        $user = Auth::user();

        if(!is_null($user)) {
            if ($user['role'] == 'admin') {
                if (!Hash::check($request['current_password'], $user['password'])) {
                    $user = [];
                    $message = 'password is incorrect';
                    $code = 401;
                } else {
                    $user['password'] = Hash::make($request['password']);
                    $user->save();
                    $user = $this->appendRolesAndPermissions($user);
                    $message = 'password updated successfully';
                    $code = 200;
                }
            } else {
                $user = [];
                $message = 'not an admin';
                $code = 403;
            }
        } else {
            $user = [];
            $message = 'user not found';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }

    public function addModerator($request): array
    {
        $user = Auth::user();

        if(!is_null($user)) {
            $imagePath = ' ';
            if($request->hasFile('image')) {

                $ext = $request->file('image')->extension();

                $final_name = date('YmdHis') . '.' . $ext;

                $request->file('image')->move(public_path('uploads/users'), $final_name);

                $imagePath = '/uploads/users/' . $final_name;
            }
            $moderator = User::query()->create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'image' => $imagePath,
                'role' => 'moderator'
            ]);

            $moderatorRole = Role::query()->where('name', 'moderator')->first();
            $moderator = $moderator->assignRole($moderatorRole);

            $permissions = $moderatorRole->permissions()->pluck('name')->toArray();
            $moderator->givePermissionTo($permissions);

            $moderator->load('roles', 'permissions');

            $moderator = User::query()->find($moderator['id']);
            $moderator = $this->appendRolesAndPermissions($moderator);

            $message = 'created successfully';
            $code = 201;
        } else {
            $user = [];
            $message = 'invalid token';
            $code = 401;
        }

        return ['user' => $moderator, 'message' => $message, 'code' => $code];
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
