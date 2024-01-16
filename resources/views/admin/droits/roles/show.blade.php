@extends('layouts.single')

@section('title', 'Fiche rôle')

@section('content')
<h1 class="text-3xl text-blue-600 text-center mb-5">Rôle : {{ $role->name }}</h1>
<div class="text-blue-900 w-screen flex justify-center items-center flex-col gap-7">
<div class="bg-white rounded-2xl px-4 space-y-2 w-96 shadow-lg">
    <div class="bg-white rounded-2xl mt-5">
        <form method="get" action="{{ route('admin.droits.roles.update', $role->id) }}">
            <x-input type="text" id="rolename" name="rolename" :value="$role->name">Nom : </x-input>
            {{--<x-button class="btn-rename">Renommer</x-button>--}}
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
            <x-button class="btn-addroleperm">Ajouter</x-button>
            </div>
        </form>
    </div>    
    <div class="bg-white rounded-2xl pb-3 px-4 space-y-2">
        <form method="get" action="{{ route('admin.droits.roles.index') }}">
            <x-button class="btn-back">Retour</x-button>
        </form>
    </div>
</div>
</div>
@endsection
