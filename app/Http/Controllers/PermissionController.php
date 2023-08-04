<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth','check','useractive']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::All();

        return view('admin.droits.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.droits.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => "web",
        ]);
        
        session()->flash('msg', 'Nouvelle permission créée');
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::where('id', $id)->firstOrFail();

        $roles = Role::All();

        return view('admin.droits.permissions.show', compact('roles', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function giveRole(Request $request, Permission $permission)
    {
        if($permission->hasRole($request->role)){
            return back()->with('message', 'Role exists.');
        }
        $permission->assignRole($request->role);
        return back()->with('message', 'Role added.');
    }

    public function revokeRole(Permission $permission, Role $role)
    {
        if($permission->hasRole($role)){
            $permission->removeRole($role);
            return back()->with('message', 'Role revoked.');
        }
        return back()->with('message', 'Role not exists.');
    }
}
