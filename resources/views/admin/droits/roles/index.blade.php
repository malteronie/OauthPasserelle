@extends('layouts.single')

@section('title', 'Admin : Liste des rôles')

@section('content')

<div class="justify-center flex ">
<div class="w-3/12">

</div>
<div class="shadow shadow-lg w-6/12 rounded-2xl py-7 px-4 space-y-2">
    <h1 class="text-3xl text-blue-600 text-center mb-5">Liste des rôles</h1>

    <table class="w-full max-w-3xl mx-auto rounded-lg border-collapse border-2 shadow-md p-5 mb-5">
        <thead class="border-gray-300 border-2 text-xl">
        <th class="border whitespace-nowrap">Nom</th>
        <th class="border whitespace-nowrap">Permission(s) associée(s)</th>
        <th class="border whitespace-nowrap">Actions</th>
        </thead>
        <tbody>
        @foreach ($roles as $role)
        <tr class="odd:bg-blue-50 even:bg-white">
            <td class="border whitespace-nowrap text-center">{{ $role->name }}</td>
            <td class="border whitespace-nowrap text-center">
            @if($role->permissions)
                @foreach ($role->permissions as $role_permission)
                    {{ $role_permission->name }} <br>
                @endforeach
            @endif
            </td>
            <td class="border whitespace-nowrap px-12">
                <x-button class="btn-blue"><a href="{{ route('admin.droits.roles.show', $role->id) }}">Editer</a></x-button>
                <x-button class="btn-blue mb-3"><a href="{{ route('admin.droits.roles.show', $role->id) }}">Editer</a></x-button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ route('admin.droits.roles.create') }}">
            <x-button class="btn-add">Ajouter</x-button>
        </form>
    </div>

    <div class="justify-center bg-white rounded-2xl py-3 px-4 flex">
        <form method="get" action="{{ URL::previous() }}">
            <x-button class="btn-back">Retour</x-button>
        </form>
    </div>
</div>
<div class="w-3/12">

</div>
</div>

@endsection
