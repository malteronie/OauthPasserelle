<?php

namespace App\Http\Controllers;

use App\Events\ActiveUserEvent;
use App\Events\DeleteUserEvent;
use App\Events\NewUserEvent;
use App\Events\ReinitPwdEvent;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * List all users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $users = User::orderby('name')->paginate(5);

        return view('admin.droits.users.index', compact('users'));
    }

    /**
     * Form to create new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.droits.users.create');
    }

    /**
     * Activate a selected user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function activate($id)
    {

        $user = User::where('id', $id)->first();

        if ($user->active == 0) {
            $user->active = true;
            $user->save();
            event(new ActiveUserEvent($user->toArray()));

            return to_route('admin.droits.users.show', $user)->with('success', 'L\'utilisateur '.$user->name.' a bien été activé');
        } else {
            $user->active = false;
            $user->save();

            return to_route('admin.droits.users.show', $user)->with('success', 'L\'utilisateur '.$user->name.' a bien été désactivé');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
     */
    public function store(StoreUserRequest $request)
    {

        $users = new User;
        $users->login = $request->login;
        $users->name = Str::random(10);
        $users->email = $request->email;

        if (env('APP_ONLINE')) {
            /**
             * Si version en ligne avec messagerie utiliser ceci
             */
            $password = Str::password(12);
        } else {
            /**
             * Si version hors ligne sans messagerie utiliser ceci
             * Vous pouvez évidemment remplacer PASSWORD par le mot de passe que vous souhaitez mettre par défaut dans votre application
             */
            $password = 'password';
        }

        $users->password = Hash::make($password);
        $users->save();

        event(new NewUserEvent($request->validated(), $password));

        return to_route('admin.droits.users.index')->with('success', 'Le nouvel utilisateur a bien été créé');
    }

    /**
     * Add a permission to a role
     *
     * @return \Illuminate\View\View
     */
    public function permtorole()
    {
        //On charge toutes les permissions existantes
        $permissions = Permission::Latest()->get();
        //On charge tous les rôles existants
        $roles = Role::Latest()->get();

        return view('admin.permtorole', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
     */
    public function createrole(Request $request)
    {

        $roles = new Role;
        $roles->name = $request->rolename;
        $roles->save();

        return $this->index()->with('success', 'Nouveau rôle créé');
    }

    /**
     * Update user.
     *
     *
     * @return \Illuminate\View\View
     */
    public function update(UpdateUserRequest $request)
    {
        /**
         * @var User $users
         */
        $users = User::findOrFail($request->id);
        $usersname = strtoupper($request->name);
        if (empty($usersname)) {
            return to_route('admin.droits.users.show', $request->id)->with('error', 'Utilisateur non modifé, données incorrectes !');
        }
        $users->save();

        return to_route('admin.droits.users.show', $request->id)->with('success', 'Utilisateur mis à jour');
    }

    /**
     * Show user
     *
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {

        $roles = Role::All();

        return view('admin.droits.users.show', compact('user', 'roles'));
    }

    /**
     * Delete user
     *
     * @param  User  $user, \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, Request $request)
    {
        event(new DeleteUserEvent($user->toArray(), $request->toArray()));
        User::find($user->id)->delete();

        return to_route('admin.droits.users.index')->with('success', 'L\'utilisateur '. $user->name . ' a bien été supprimé');
    }

    /**
     * Change password
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'new_pwd' => 'required|min:9',
            'new_pwd2' => 'required|min:9|same:new_pwd',
        ], [
        ]);

        if (! (Hash::check($request->get('pwd'), Auth::user()->password))) {
            return back()->with('error', 'Votre mot de passe actuel ne correspond pas avec le mot de passe que vous avez renseigné');
        }
        if (strcmp($request->get('pwd'), $request->get('new_pwd')) == 0) {
            return back()->with('error', 'Votre nouveau mot de passe ne doit pas être pareil que votre ancien mot de passe');
        }if ($request->get('pwd') === $request->get('new_pwd')) {
            return back()->with('error', 'Nouveau mot de passe ou confirmation de mot de passe incorrect');
        } else {
            $user = Auth::user();
            $user->password = bcrypt($request->get('new_pwd'));
            $user->save();

            return redirect('/');
        }
    }

    /**
     * Check correct password
     *
     * @return \Illuminate\View\View
     */
    public function check()
    {
        return view('auth.changepwd');
    }

    /**
     * Check reinit password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function reinit($request)
    {

        $users = User::findOrFail($request);

        if (env('APP_ONLINE')) {
            /**
             * Si version en ligne avec messagerie utiliser ceci
             */
            $password = Str::password(12);
        } else {
            /**
             * Si version hors ligne sans messagerie utiliser ceci
             * Vous pouvez évidemment remplacer PASSWORD par le mot de passe que vous souhaitez mettre par défaut dans votre application
             */
            $password = 'password';
        }

        $users->password = Hash::make($password);
        $users->save();
        if (env('APP_ONLINE'))
        {
            event(new ReinitPwdEvent($users->email, $password));

            return to_route('admin.droits.users.show',$users)->with('success', 'Le mot de passe a bien été réinitialisé');
        }
        else
        {
            return to_route('admin.droits.users.show',$users)->with('success', 'Le mot de passe a bien été réinitialisé par ' . $password);
        }
    }

    /**
     * Check profile
     *
     *
     * @return \Illuminate\View\View
     */
    public function profile(User $user)
    {
        if (Auth::user() == $user or Auth::user()->hasrole(\App\Enums\RoleEnum::SUPER_ADMIN->value) or Auth::user()->hasrole(\App\Enums\RoleEnum::ADMINDROITS->value)) {
            //$user = User::find($user);

            return view('auth.profile', compact('user'));
        }
        abort(403, 'Vous n\'avez pas le droit de visualiser cette page.');
    }

    /**
     * give role to user
     *
     * @param  \Illuminate\Http\Request  $request, User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function giveRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('warning', 'Le rôle est déjà attribué.');
        }
        if ($request->role == \App\Enums\RoleEnum::ADMINDROITS->value) {
            if (Auth::user()->can('create_droits')) {
                $user->assignRole($request->role);
            } else {
                return back()->with('error', 'Vous ne pouvez pas ajouter ce rôle.');
            }
        } elseif ($request->role == \App\Enums\RoleEnum::SUPER_ADMIN->value) {
            if (Auth::user()->hasrole(\App\Enums\RoleEnum::SUPER_ADMIN->value)) {
                $user->assignRole($request->role);
            } else {
                return back()->with('error', 'Vous ne pouvez pas ajouter ce rôle.');
            }
        } else {
            if (Auth::user()->can('create_droits')) {
                $user->assignRole($request->role);
            }
        }

        return back()->with('success', 'Le rôle a bien été ajouté.');
    }

    /**
     * revoke role from user
     *
     * @param  User  $user, Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revokeRole(User $user, Role $role)
    {
        if ($role->name == \App\Enums\RoleEnum::SUPER_ADMIN->value and ! Auth::user()->hasrole(\App\Enums\RoleEnum::SUPER_ADMIN->value)) {
            return back()->with('warning', 'Vous ne pouvez pas retirer ce rôle');
        }
        if ($role->name == \App\Enums\RoleEnum::ADMINDROITS->value and ! Auth::user()->hasrole(\App\Enums\RoleEnum::ADMINDROITS->value)) {
            return back()->with('warning', 'Vous ne pouvez pas retirer ce rôle');
        }
        if ($user->hasRole(strtolower($role->name))) {
            $user->removeRole($role->name);

            return back()->with('success', 'Le rôle a bien été retiré.');
        }

        return back()->with('warning', 'Le rôle n\'existe pas.');
    }
}
