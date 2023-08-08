<?php

namespace App\Http\Controllers;

use App\Events\NewUserEvent;
use App\Events\ReinitPwdEvent;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\ActiveUserMail;
use App\Mail\DestroyUserMail;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        //dd($user);

        if ($user->active == 0) {
            $user->active = true;
            $user->save();
            Mail::send(new ActiveUserMail($user->toArray()));

            return $this->show($user)->with('success', 'L\'utilisateur '.$user->name.' a bien été activé');
        } else {
            $user->active = false;
            $user->save();

            return $this->show($user)->with('success', 'L\'utilisateur '.$user->name.' a bien été désactivé');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function store(StoreUserRequest $request)
    {

        $users = new User;
        $users->login = $request->login;
        $users->name = Str::random(10);
        $users->email = $request->email;
        /**
         * Si version en ligne avec messagerie utiliser ceci
         */
        $password = Str::password(12);
        /**
         * Si version hors ligne sans messagerie utiliser ceci
         * Vous pouvez évidemment remplacer PASSWORD par le mot de passe que vous souhaitez mettre par défaut dans votre application
         */
        //$password = 'password';

        $users->password = Hash::make($password);
        $users->save();

        event(new NewUserEvent($request->validated(), $password));

        return $this->index()->with('success', 'Le nouvel utilisateur a bien été créé');
    }

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

    public function update(UpdateUserRequest $request)
    {
        $users = User::findOrFail($request->id);
        $users = strtoupper($request->name);
        if (is_null($users)) {
            return $this->show($request->id)->with('error', 'Utilisateur non modifé, données incorrectes !');
        }
        $users->save();

        return $this->show($users->id)->with('success', 'Utilisateur mis à jour');
    }

    public function show(User $user)
    {

        $roles = Role::All();

        return view('admin.droits.users.show', compact('user', 'roles'));
    }

    public function destroy(User $user, Request $request)
    {
        Mail::send(new DestroyUserMail($user->toArray(), $request->content));
        User::find($user->id)->delete();

        return to_route('admin.droits.users.index');
    }

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

    public function check()
    {
        return view('auth.changepwd');
    }

    public function reinit($request)
    {

        $users = User::findOrFail($request);
        /**
         * Si version en ligne avec messagerie utiliser ceci
         */
        $password = Str::password(12);
        /**
         * Si version hors ligne sans messagerie utiliser ceci
         * Vous pouvez évidemment remplacer PASSWORD par le mot de passe que vous souhaitez mettre par défaut dans votre application
         */
        //$password = 'password';

        $users->password = Hash::make($password);
        $users->save();

        event(new ReinitPwdEvent($users->email, $password));

        return $this->show($users)->with('success', 'Le mot de passe a bien été réinitialisé');
    }

    public function profile(User $user)
    {
        if (Auth::user() == $user or Auth::user()->hasrole('admindroits')) {
            //$user = User::find($user);

            return view('auth.profile', compact('user'));
        }
        abort(403, 'Vous n\'avez pas le droit de visualiser cette page.');
    }

    public function giveRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('warning', 'Le rôle est déjà attribué.');
        }
        $user->assignRole($request->role);

        return back()->with('success', 'Le rôle a bien été ajouté.');
    }

    public function revokeRole(User $user, Role $role)
    {
        if ($user->hasRole(strtolower($role->name))) {
            $user->removeRole($role->name);

            return back()->with('success', 'Le rôle a bien été retiré.');
        }

        return back()->with('warning', 'Le rôle n\'existe pas.');
    }
}
