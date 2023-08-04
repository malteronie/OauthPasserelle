@extends('layouts.single')

@section('title', 'Fiche permission')

@section('content')
<h1 class="text-3xl text-blue-600 text-center mb-5">Permission : {{ ucfirst($permission->name) }}</h1>
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
<div class="bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
    <div class="bg-white rounded-2xl mt-5">
        <form method="get" action="{{ route('admin.droits.permissions.update', $permission->id) }}">
            @csrf
            <label for="permissionname">Nom : </label>
            <input type="text" id="permissionname" name="permissionname" value="{{ $permission->name }}" class="  px-3 py-2 rounded-xl bg-indigo-50/70 outline-none focus:bg-indigo-100/100" />
            <button class="mt-4 bg-red-500 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" type="submit">
                    Renommer
            </button>
        </form>        
    </div>
    <div class="bg-white rounded-2xl pt-5 pb-2 px-4 space-y-2">
        @if($permission->roles)
            @foreach ($permission->roles as $permission_role)
            <form class="mb-2 px-4 py-2 bg-black hover:bg-red-700 text-white rounded-md shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" method="POST" action="{{ route('admin.droits.permissions.roles.revoke', [$permission->id, $permission_role->id]) }}" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button class="text-white w-full rounded-xl" type="submit">{{ $permission_role->name }}</button>
            </form>
            @endforeach
        @endif
    </div>
    <div class="bg-white rounded-2xl px-4 space-y-2">
        <form method="POST" action="{{ route('admin.droits.permissions.roles', $permission->id) }}">
            @csrf
            <div class="">
                <h4>Rôle :   </h4>
                <select id="role" name="role" autocomplete="role-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('name')
                <span class="text-red-400 text-sm">{{ $message }}</span>
            @enderror
            <div class="">
            <button class="mt-4 bg-green-600 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-green-200 hover:bg-green-700" type="submit">
                    Ajouter
            </button>
            </div>
        </form>
    </div>    
    <div class="bg-white rounded-2xl pb-3 px-4 space-y-2">
        <form method="get" action="{{ route('admin.droits.permissions.index') }}">
            @csrf
            <button class="mt-4 bg-orange-600 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-orange-200 hover:bg-orange-700" type="submit">
                    Retour
            </button>
        </form>
    </div>
</div>
</div>
@endsection
