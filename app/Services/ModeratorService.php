<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ModeratorService
{
    public function register($request): array
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
                'password' => Hash::make($request['password']),
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'image' => $imagePath,
                'role' => 'moderator'
            ]);

            $moderatorRole = Role::query()->firstWhere('name', 'moderator');
            $user = $user->assignRole($moderatorRole);

            $permissions = $moderatorRole->permissions()->pluck('name')->toArray();
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
    public function login($request): array
    {
        $user = User::query()->where('phone', $request['phone'])->first();
        if(!is_null($user)) {

            if ($user['role'] == 'admin' || $user['role'] == 'moderator') {

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
                $message = 'client account';
                $code = 403;
            }
        }
        else {
            $message = 'user not found';
            $code = 404;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }
    public function logout(): array
    {
        $user = Auth::user();

        if(!is_null($user)) {
            if ($user['role'] == 'admin' || $user['role'] == 'moderator') {
                $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
                $message = 'user logged out successfully';
                $code = 200;
            } else {
                $user = [];
                $message = 'client account';
                $code = 403;
            }
        }
        else {
            $message = 'invalid token';
            $code = 401;
        }

        return ['user' => $user, 'message' => $message, 'code' => $code];
    }
    public function changePassword($request): array
    {
        $user = Auth::user();

        if(!is_null($user)) {
            if ($user['role'] == 'admin' || $user['role'] == 'moderator') {
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
                $message = 'client account';
                $code = 403;
            }
        }
        else {
            $message = 'user not found';
            $code = 404;
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
