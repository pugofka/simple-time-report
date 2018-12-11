<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Role as RoleConst;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = \App\User::create([
            'name' => 'admin',
            'email' => 'info@pugofka.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
        ]);

        $userUser = \App\User::create([
            'name' => 'Karmov',
            'email' => 'Karmov@pugofka.com',
            'password' => \Illuminate\Support\Facades\Hash::make('swqqpl22'),
        ]);

        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => RoleConst::ROLE_ADMIN]);
        $roleUser = \Spatie\Permission\Models\Role::create(['name' => RoleConst::ROLE_USER]);

        $userAdmin->assignRole(RoleConst::ROLE_ADMIN);
        $userUser->assignRole(RoleConst::ROLE_USER);
    }
}
