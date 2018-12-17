<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Role as RoleConst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{




    public function index()
    {
        $users = User::get();
        $usersCount = count($users);
        for ($i=0; $i < $usersCount; $i++) {
            $users[$i]->role = $users[$i]->getRoleNames()[0];
        }

        return view('users.index', compact('users'));
    }




    public function create(Request $request)
    {
        return view('users.create');
    }




    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'plane_hours' => $request['plane_hours'],
            'week_hours' => $request['week_hours'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);


        if ($request['role'] === "user") {
            $user->assignRole(RoleConst::ROLE_USER);
        } else {
            $user->assignRole(RoleConst::ROLE_ADMIN);
        }

        $user->save();

        return redirect(route('users.index'))->with('status', 'Пользователь успешно создан');
    }



    public function edit($id, Request $request)
    {
        $user = User::findOrFail($id);
        $role = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());

        return view('users.edit', compact('user','role'));
    }



    public function update($id, Request $request, User $user)
    {
        $user = User::findOrFail($id);
        $oldRole = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());

        $user->name   = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->plane_hours = $request->input('plane_hours');
        $user->week_hours = $request->input('week_hours');
        $user->removeRole($oldRole);
        $user->assignRole($request->input('role'));
        if ($request->password !== null) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect(route('users.index'))->with('status', 'Пользователь успешно обновлен');
    }




    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('users.index'))->with('status', 'Пользователь удален');
    }
}
