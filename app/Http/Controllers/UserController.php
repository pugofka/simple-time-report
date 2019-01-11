<?php
/**
 * MyClass File Doc Comment
 * php version 7.2
 *
 * @category MyClass
 * @package  MyPackage
 * @author   Pugofka <info@pugofka.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 */
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Role as RoleConst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * MyClass Class Doc Comment
 *
 * @category Class
 * @package  MyPackage
 * @author   Pugofka <info@pugofka.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 */
class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::get();
        $usersCount = count($users);
        for ($i = 0; $i < $usersCount; $i++) {
            $users[$i]->role = $users[$i]->getRoleNames()[0];
        }

        return view('users.index', compact('users'));
    }

    /**
     * Сreation of users by the administrator
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store of users by the administrator
     *
     * @param Request $request The comment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = User::create(
            [
                'name' => $request['name'],
                'lastname' => $request['lastname'],
                'plane_hours' => $request['plane_hours'],
                'week_hours' => $request['week_hours'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]
        );

        if ($request['role'] === RoleConst::ROLE_ADMIN) {
            $user->assignRole(RoleConst::ROLE_ADMIN);
            $user->is_admin = 1;
        } else {
            $user->assignRole(RoleConst::ROLE_USER);
        }


        $user->save();

        return redirect(route('users.index'))
            ->with('status', 'Пользователь успешно создан');
    }

    /**
     * Editin of users by the administrator
     *
     * @param int $id The user id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());
        return view('users.edit', compact('user', 'role'));
    }

    /**
     * Updating of users by the administrator
     *
     * @param int     $id      THE COMMENT
     * @param Request $request The comment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $oldRole = preg_replace('/[^a-z_]/i', '', $user->getRoleNames());
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->plane_hours = $request->input('plane_hours');
        $user->week_hours = $request->input('week_hours');
        $user->removeRole($oldRole);
        $user->assignRole($request->input('role'));

        if ($request->input('role') === 'admin') {
            $user->is_admin = 1;
        } else {
            $user->is_admin = 0;
        }

        if ($request->password !== null) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect(route('users.index'))
            ->with('status', 'Пользователь успешно обновлен');
    }

    /**
     * Destroy of users by the administrator
     *
     * @param int $id The user id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(
            route('users.index')
        )->with('status', 'Пользователь успешно удален');
    }
}