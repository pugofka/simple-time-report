<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Role as RoleConst;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        for ($i=0; $i < count($users); $i++) {    // подсчет часов этапов
            $users[$i]->role = preg_replace('/[^a-z_]/i', '', $users[$i]->getRoleNames());
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $user = User::find($id);
        $role = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());

        return view('users.edit', compact('user','role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, User $user)
    {
        $user = User::find($id);
        $oldRole = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());

        $user->name   = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->removeRole($oldRole);
        $user->assignRole($request->input('role'));
        if ($request->password !== null) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect(route('users.index'))->with('status', 'Пользователь успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect(route('users.index'))->with('status', 'Пользователь удален');
    }
}
