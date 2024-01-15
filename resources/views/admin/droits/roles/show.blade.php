@extends('layouts.single')

@section('title', 'Fiche rôle')

@section('content')
<h1 class="text-3xl text-blue-600 text-center mb-5">Rôle : {{ $role->name }}</h1>
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
<div class="bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
    <div class="bg-white rounded-2xl mt-5">
        <form method="get" action="{{ route('admin.droits.roles.update', $role->id) }}">
            <x-input type="text" id="rolename" name="rolename" :value="$role->name">Nom : </x-input>
            <x-button class="mt-4 btn-rename">Renommer</x-button>
        </form>        
    </div>
    <div class="bg-white rounded-2xl pt-5 pb-2 px-4 space-y-2">
        @if($role->permissions)
            @foreach ($role->permissions as $role_permission)
            <form class="mb-2 px-4 py-2 bg-black hover:bg-red-700 text-white rounded-md shadow hover:shadow-lg hover:shadow-red-200 hover:bg-red-700" method="POST" action="{{ route('admin.droits.roles.permissions.revoke', [$role->id, $role_permission->id]) }}" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button class="text-white w-full rounded-xl" type="submit">{{ $role_permission->name }}</button>
            </form>
            @endforeach
        @endif
    </div>
    <div class="bg-white rounded-2xl px-4 space-y-2">
        <form method="POST" action="{{ route('admin.droits.roles.permissions', $role->id) }}">
            @csrf
            <div class="">
                <h4>Permission :   </h4>
                <select id="permission" name="permission" autocomplete="permission-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
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
        <form method="get" action="{{ route('admin.droits.roles.index') }}">
            <button class="mt-4 bg-orange-600 text-white w-full rounded-xl py-2 shadow hover:shadow-lg hover:shadow-orange-200 hover:bg-orange-700" type="submit">
                    Retour
            </button>
        </form>
    </div>
</div>
</div>
@endsection
