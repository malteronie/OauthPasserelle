<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth','check','useractive']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $roles = Role::All();

        return view('admin.droits.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.droits.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return View
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return $this->index()->with('success', 'Le rôle a bien été créé');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $role = Role::where('id', $id)->firstOrFail();

        $permissions = Permission::All();

        return view('admin.droits.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return View
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        //dd($request);
        $role = Role::findOrFail($id);
        $role = $request->name;

        if (is_null($role)) {
            session()->flash('errmsg', 'Rôle non modifé, données incorrectes !');

            return $this->show($request->id);
        }
        $role->save();
        session()->flash('msg', 'Rôle renommé');

        return $this->show($role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function givePermission(Request $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);

        return back()->with('message', 'Permission added.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role, Permission $permission
     * @return RedirectResponse
     */
    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);

            return back()->with('message', 'Permission revoked.');
        }

        return back()->with('message', 'Permission not exists.');
    }
}
